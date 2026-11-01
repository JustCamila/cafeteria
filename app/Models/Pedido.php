<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    protected $fillable = ['cliente_id', 'data_hora', 'forma_pagamento', 'valor_total'];

    protected function casts(): array
    {
        return ['data_hora' => 'datetime', 'valor_total' => 'decimal:2'];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id_cliente');
    }

    public function itens(): HasMany
    {
        return $this->hasMany(ItemPedido::class, 'pedido_id', 'id_pedido');
    }

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'itens_pedido', 'pedido_id', 'produto_id', 'id_pedido', 'id_produto')
                    ->withPivot('quantidade', 'preco_unitario');
    }
}
