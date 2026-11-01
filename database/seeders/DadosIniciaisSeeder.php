<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DadosIniciaisSeeder extends Seeder
{
    /**
     * Popula o banco com a carga do 1º bimestre (20 produtos,
     * 15.000 clientes e 15.000 pedidos), lida de database/sql/seed_dados.sql.
     */
    public function run(): void
    {
        // Desliga as triggers durante a carga histórica: as triggers de estoque
        // (feitas depois pela Leticia) bloqueariam vendas de produtos com estoque 0.
        DB::statement('ALTER TABLE pedido DISABLE TRIGGER USER');
        DB::statement('ALTER TABLE itens_pedido DISABLE TRIGGER USER');

        DB::unprepared(file_get_contents(database_path('sql/seed_dados.sql')));

        DB::statement('ALTER TABLE pedido ENABLE TRIGGER USER');
        DB::statement('ALTER TABLE itens_pedido ENABLE TRIGGER USER');
    }
}