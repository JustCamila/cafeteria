<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use RuntimeException;

// regras do CRUD de pedidos
// importante: o estoque NÃO é alterado aqui. A trigger trg_controlar_estoque devolve e baixa
// o estoque quando um item é criado, editado ou excluído, e a trigger trg_atualizar_valor_total
// recalcula o valor_total do pedido. O código só mexe nos itens.
class PedidoService
{
    // a busca aceita o número do pedido ou o CPF do cliente
    public function listar(?string $busca, ?string $formaPagamento, int $porPagina = 15): LengthAwarePaginator
    {
        $numeros = preg_replace('/\D/', '', (string) $busca);

        return Pedido::query()
            ->with('cliente:id_cliente,nome,cpf')
            ->withCount('itens')
            ->when(strlen($numeros) === 11, fn ($query) => $query->whereHas('cliente', fn ($q) => $q->where('cpf', $numeros)))
            ->when($numeros !== '' && strlen($numeros) !== 11, fn ($query) => $query->where('id_pedido', (int) $numeros))
            ->when($formaPagamento, fn ($query) => $query->where('forma_pagamento', $formaPagamento))
            ->orderByDesc('id_pedido')
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function carregar(Pedido $pedido): Pedido
    {
        return $pedido->load(['cliente', 'itens' => fn ($query) => $query->orderBy('id_itens_pedido'), 'itens.produto']);
    }

    // tudo roda numa transação: se a trigger bloquear um item por falta de estoque,
    // nenhuma alteração do pedido é salva
    public function atualizar(Pedido $pedido, array $dados): Pedido
    {
        try {
            DB::transaction(function () use ($pedido, $dados) {
                $pedido->update([
                    'cliente_id' => $this->idCliente($dados['cpf'] ?? null),
                    'forma_pagamento' => $dados['forma_pagamento'],
                ]);

                $this->atualizarItens($pedido, $dados['itens'] ?? []);
                $this->adicionarItens($pedido, $dados['novos'] ?? []);
            });
        } catch (QueryException $e) {
            throw new RuntimeException($this->mensagemAmigavel($e));
        }

        return $pedido->refresh();
    }

    // o delete do pedido apaga os itens em cascata (FK on delete cascade),
    // e a trigger de estoque devolve os produtos de cada item
    public function excluir(Pedido $pedido): void
    {
        try {
            $pedido->delete();
        } catch (QueryException $e) {
            throw new RuntimeException($this->mensagemAmigavel($e));
        }
    }

    private function idCliente(?string $cpf): ?int
    {
        return $cpf ? Cliente::where('cpf', $cpf)->value('id_cliente') : null;
    }

    // quantidade 0 remove o item; quantidade diferente atualiza; igual não faz nada
    private function atualizarItens(Pedido $pedido, array $quantidades): void
    {
        $itens = $pedido->itens()->whereKey(array_keys($quantidades))->get();

        foreach ($itens as $item) {
            $quantidade = (int) $quantidades[$item->id_itens_pedido];

            if ($quantidade === 0) {
                $item->delete();
            } elseif ($quantidade !== $item->quantidade) {
                $item->update(['quantidade' => $quantidade]);
            }
        }
    }

    // item novo grava o preço atual do produto; os itens antigos mantêm o preço da época da venda
    private function adicionarItens(Pedido $pedido, array $quantidades): void
    {
        $quantidades = array_filter(array_map('intval', $quantidades));

        if ($quantidades === []) {
            return;
        }

        $produtos = Produto::whereKey(array_keys($quantidades))->get()->keyBy('id_produto');

        foreach ($quantidades as $produtoId => $quantidade) {
            $produto = $produtos->get($produtoId);

            if (! $produto) {
                throw new RuntimeException("Produto {$produtoId} não foi encontrado.");
            }

            $pedido->itens()->create([
                'produto_id' => $produto->id_produto,
                'quantidade' => $quantidade,
                'preco_unitario' => $produto->preco_unitario,
            ]);
        }
    }

    // erros lançados pelas triggers (raise exception) chegam com o código P0001;
    // a mensagem da trigger é mostrada para o usuário, o resto vira uma mensagem padrão
    private function mensagemAmigavel(QueryException $e): string
    {
        if (($e->errorInfo[0] ?? null) !== 'P0001') {
            return 'Não foi possível salvar o pedido.';
        }

        preg_match('/^[A-Z]+:\s+(.+)$/mu', $e->errorInfo[2], $partes);

        return ucfirst($partes[1] ?? 'Não foi possível salvar o pedido.');
    }
}
