<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->foreignId('cliente_id')->nullable()
                ->constrained('cliente', 'id_cliente')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('data_hora')->useCurrent();
            $table->string('forma_pagamento', 50);
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
