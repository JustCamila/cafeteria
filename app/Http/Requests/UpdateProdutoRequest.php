<?php

namespace App\Http\Requests;

// na edição as regras são as mesmas do cadastro, menos o estoque:
// depois de cadastrado, o estoque só muda pela reposição (sp_repor_estoque)
// e pelas vendas (trigger trg_controlar_estoque)
class UpdateProdutoRequest extends StoreProdutoRequest
{
    public function rules(): array
    {
        $regras = parent::rules();
        unset($regras['estoque']);

        return $regras;
    }
}
