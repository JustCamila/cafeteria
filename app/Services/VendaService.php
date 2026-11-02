<?php

namespace App\Services;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class VendaService
{
    public function registrarVenda(?string $cpf, string $formaPagamento, array $itens): void
    {
        $produtos = '{' . implode(',', array_keys($itens)) . '}';
        $quantidades = '{' . implode(',', array_values($itens)) . '}';

        $this->executar('CALL sp_registrar_venda(?, ?, ?, ?)', [$cpf, $formaPagamento, $produtos, $quantidades]);
    }

    public function reporEstoque(int $produtoId, int $quantidade): void
    {
        $this->executar('CALL sp_repor_estoque(?, ?)', [$produtoId, $quantidade]);
    }

    private function executar(string $sql, array $parametros): void
    {
        try {
            DB::statement($sql, $parametros);
        } catch (QueryException $e) {
            throw new RuntimeException($this->mensagemAmigavel($e));
        }
    }

    private function mensagemAmigavel(QueryException $e): string
    {
        if (($e->errorInfo[0] ?? null) !== 'P0001') {
            return 'Não foi possível concluir a operação.';
        }

        preg_match('/^[A-Z]+:\s+(.+)$/mu', $e->errorInfo[2], $partes);

        return ucfirst($partes[1] ?? 'Não foi possível concluir a operação.');
    }
}
