<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    protected $fillable = ['cpf', 'nome', 'telefone', 'email'];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'cliente_id', 'id_cliente');
    }

    // no banco ficam só os números; nas telas aparece 000.000.000-00
    protected function cpfFormatado(): Attribute
    {
        return Attribute::get(fn () => preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', (string) $this->cpf));
    }

    // (00) 00000-0000 ou (00) 0000-0000
    protected function telefoneFormatado(): Attribute
    {
        return Attribute::get(fn () => preg_replace('/^(\d{2})(\d{4,5})(\d{4})$/', '($1) $2-$3', (string) $this->telefone));
    }
}
