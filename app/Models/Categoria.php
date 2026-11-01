<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    protected $fillable = ['nome'];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'categoria_id', 'id_categoria');
    }
}
