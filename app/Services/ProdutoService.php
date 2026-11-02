<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProdutoService
{
    public function listar(?string $busca, ?int $categoriaId, int $porPagina = 10): LengthAwarePaginator
    {
        return Produto::query()
            ->with('categoria')
            ->when($busca, fn ($query) => $query->where('nome', 'ilike', "%{$busca}%"))
            ->when($categoriaId, fn ($query) => $query->where('categoria_id', $categoriaId))
            ->orderBy('nome')
            ->paginate($porPagina)
            ->withQueryString();
    }

    // quantas unidades já foram vendidas e quanto o produto já faturou
    public function resumoVendas(Produto $produto): object
    {
        return $produto->itens()
            ->selectRaw('coalesce(sum(quantidade), 0) as quantidade, coalesce(sum(quantidade * preco_unitario), 0) as faturamento')
            ->toBase()
            ->first();
    }

    // produto e detalhe do café são gravados juntos: se um falhar, nada é salvo
    public function criar(array $dados): Produto
    {
        return DB::transaction(function () use ($dados) {
            $produto = Produto::create($this->dadosProduto($dados) + ['estoque' => $dados['estoque'] ?? 0]);

            $this->salvarDetalheCafe($produto, $dados);

            return $produto;
        });
    }

    public function atualizar(Produto $produto, array $dados): Produto
    {
        return DB::transaction(function () use ($produto, $dados) {
            $produto->update($this->dadosProduto($dados));

            $this->salvarDetalheCafe($produto, $dados);

            return $produto;
        });
    }

    // a FK de itens_pedido é "on delete restrict": produto que já foi vendido não pode ser excluído
    public function excluir(Produto $produto): void
    {
        try {
            $produto->delete();
        } catch (QueryException $e) {
            if (($e->errorInfo[0] ?? null) === '23503') {
                throw new RuntimeException('Esse produto já aparece em pedidos e não pode ser excluído.');
            }

            throw $e;
        }
    }

    private function dadosProduto(array $dados): array
    {
        return [
            'categoria_id' => $dados['categoria_id'] ?? null,
            'nome' => $dados['nome'],
            'descricao' => $dados['descricao'],
            'preco_unitario' => $dados['preco_unitario'],
        ];
    }

    // se o produto é um café, cria ou atualiza o detalhe (relação 1:1); se deixou de ser, remove
    // quando eh_cafe não é enviado, o detalhe fica como está
    private function salvarDetalheCafe(Produto $produto, array $dados): void
    {
        if (! array_key_exists('eh_cafe', $dados)) {
            return;
        }

        if (! $dados['eh_cafe']) {
            $produto->detalheCafe()->delete();

            return;
        }

        $produto->detalheCafe()->updateOrCreate([], [
            'origem_grao' => $dados['origem_grao'],
            'tipo_torra' => $dados['tipo_torra'],
            'notas_degustacao' => $dados['notas_degustacao'] ?? null,
        ]);
    }
}
