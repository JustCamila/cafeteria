<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalheCafe extends Model
{
    protected $table = 'detalhe_cafe';
    protected $primaryKey = 'id_cafe';
    protected $fillable = ['produto_id', 'origem_grao', 'notas_degustacao', 'tipo_torra'];

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'id_produto');
    }
}