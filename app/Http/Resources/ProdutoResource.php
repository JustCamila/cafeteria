<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_produto,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'preco_unitario' => (float) $this->preco_unitario,
            'estoque' => $this->estoque,
            'categoria' => $this->whenLoaded('categoria', fn () => $this->categoria ? [
                'id' => $this->categoria->id_categoria,
                'nome' => $this->categoria->nome,
            ] : null),
            'detalhe_cafe' => $this->whenLoaded('detalheCafe', fn () => $this->detalheCafe ? [
                'origem_grao' => $this->detalheCafe->origem_grao,
                'tipo_torra' => $this->detalheCafe->tipo_torra,
                'notas_degustacao' => $this->detalheCafe->notas_degustacao,
            ] : null),
        ];
    }
}