<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Índice 1: histórico de compras do cliente.
        DB::statement('CREATE INDEX idx_pedido_cliente_data
                       ON pedido (cliente_id, data_hora DESC)
                       INCLUDE (valor_total, forma_pagamento)');

        // Índice 2: itens de um pedido.
        DB::statement('CREATE INDEX idx_itens_pedido_pedido
                       ON itens_pedido (pedido_id)
                       INCLUDE (produto_id, quantidade, preco_unitario)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS idx_pedido_cliente_data');
        DB::statement('DROP INDEX IF EXISTS idx_itens_pedido_pedido');
    }
};