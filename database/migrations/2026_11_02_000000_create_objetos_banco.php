<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(file_get_contents(database_path('sql/functions.sql')));
        DB::unprepared(file_get_contents(database_path('sql/procedures.sql')));
        DB::unprepared(file_get_contents(database_path('sql/triggers.sql')));
    }

    public function down(): void
    {
        DB::unprepared('
            drop trigger if exists trg_atualizar_valor_total on itens_pedido;
            drop trigger if exists trg_controlar_estoque on itens_pedido;
            drop function if exists fn_atualizar_valor_total();
            drop function if exists fn_controlar_estoque();
            drop procedure if exists sp_repor_estoque(bigint, int);
            drop procedure if exists sp_registrar_venda(varchar, varchar, bigint[], int[]);
            drop function if exists fn_resumo_cliente(varchar);
            drop function if exists fn_produtos_mais_vendidos(int);
        ');
    }
};
