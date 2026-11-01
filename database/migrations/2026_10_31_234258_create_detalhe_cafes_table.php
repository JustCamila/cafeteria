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
        Schema::create('detalhe_cafe', function (Blueprint $table) {
            $table->id('id_cafe');
            $table->foreignId('produto_id')->unique()
                ->constrained('produto', 'id_produto')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('origem_grao', 50);
            $table->string('notas_degustacao', 50)->nullable();
            $table->string('tipo_torra', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalhe_cafes');
    }
};
