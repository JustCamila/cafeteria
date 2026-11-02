<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Pagination\LengthAwarePaginator;

class ClienteService
{
    // a busca aceita nome, e-mail ou CPF (com ou sem pontos e traço)
    public function listar(?string $busca, int $porPagina = 15): LengthAwarePaginator
    {
        $cpf = preg_replace('/\D/', '', (string) $busca);

        return Cliente::query()
            ->when($busca, function ($query) use ($busca, $cpf) {
                $query->where(function ($query) use ($busca, $cpf) {
                    $query->where('nome', 'ilike', "%{$busca}%")
                          ->orWhere('email', 'ilike', "%{$busca}%");

                    if ($cpf !== '') {
                        $query->orWhere('cpf', 'like', "{$cpf}%");
                    }
                });
            })
            ->orderBy('nome')
            ->paginate($porPagina)
            ->withQueryString();
    }

    // histórico do cliente, do pedido mais recente ao mais antigo
    // (é a consulta que usa o índice idx_pedido_cliente_data)
    public function historicoPedidos(Cliente $cliente, int $porPagina = 10): LengthAwarePaginator
    {
        return $cliente->pedidos()
            ->orderByDesc('data_hora')
            ->paginate($porPagina, ['id_pedido', 'cliente_id', 'data_hora', 'valor_total', 'forma_pagamento']);
    }

    public function criar(array $dados): Cliente
    {
        return Cliente::create($dados);
    }

    public function atualizar(Cliente $cliente, array $dados): Cliente
    {
        $cliente->update($dados);

        return $cliente;
    }

    // a FK do pedido é "on delete set null": os pedidos do cliente continuam no histórico de vendas
    public function excluir(Cliente $cliente): void
    {
        $cliente->delete();
    }
}
