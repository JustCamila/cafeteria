<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Produto extends Model
{
    use HasFactory;
    protected $table = 'produto';
    protected $primaryKey = 'id_produto';
    protected $fillable = ['categoria_id', 'nome', 'descricao', 'preco_unitario', 'estoque'];

    protected function casts(): array
    {
        return ['preco_unitario' => 'decimal:2', 'estoque' => 'integer'];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    public function detalheCafe(): HasOne
    {
        return $this->hasOne(DetalheCafe::class, 'produto_id', 'id_produto');
    }

    public function itens(): HasMany
    {
        return $this->hasMany(ItemPedido::class, 'produto_id', 'id_produto');
    }
}