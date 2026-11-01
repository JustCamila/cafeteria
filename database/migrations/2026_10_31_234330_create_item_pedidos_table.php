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
        Schema::create('itens_pedido', function (Blueprint $table) {
            $table->id('id_itens_pedido');
            $table->foreignId('pedido_id')
                ->constrained('pedido', 'id_pedido')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('produto_id')
                ->constrained('produto', 'id_produto')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pedidos');
    }
};
