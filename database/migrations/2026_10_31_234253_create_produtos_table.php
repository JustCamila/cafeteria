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
       Schema::create('produto', function (Blueprint $table) {
            $table->id('id_produto');
            $table->foreignId('categoria_id')->nullable()
                ->constrained('categoria', 'id_categoria')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->string('nome', 100)->unique();
            $table->string('descricao', 200);
            $table->decimal('preco_unitario', 10, 2);
            $table->integer('estoque')->default(0);
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
