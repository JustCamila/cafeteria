<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RelatorioService
{
    public function produtosMaisVendidos(int $limite): array
    {
        return DB::select('SELECT * FROM fn_produtos_mais_vendidos(?)', [$limite]);
    }

    public function resumoCliente(string $cpf): ?object
    {
        return DB::selectOne('SELECT * FROM fn_resumo_cliente(?)', [$cpf]);
    }
}
