<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // aceita preço com vírgula (ex.: 12,50) e trata o checkbox do café como booleano
    protected function prepareForValidation(): void
    {
        $preco = $this->input('preco_unitario');

        // "1.234,56" vira "1234.56"
        if (is_string($preco) && str_contains($preco, ',')) {
            $preco = str_replace(['.', ','], ['', '.'], $preco);
        }

        $this->merge(['preco_unitario' => $preco]);

        // o formulário sempre envia eh_cafe (campo hidden com 0 + checkbox com 1);
        // se não vier, os detalhes do café não são alterados
        if ($this->has('eh_cafe')) {
            $this->merge(['eh_cafe' => $this->boolean('eh_cafe')]);
        }
    }

    public function rules(): array
    {
        return [
            'categoria_id' => 'nullable|integer|exists:categoria,id_categoria',
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('produto', 'nome')->ignore($this->route('produto'), 'id_produto'),
            ],
            'descricao' => 'required|string|max:200',
            'preco_unitario' => 'required|numeric|min:0.01|max:99999999.99',
            'estoque' => 'nullable|integer|min:0',

            // detalhes do café: só são obrigatórios quando o produto é um café
            'eh_cafe' => 'sometimes|boolean',
            'origem_grao' => 'nullable|required_if:eh_cafe,true|string|max:50',
            'tipo_torra' => 'nullable|required_if:eh_cafe,true|in:Clara,Média,Forte',
            'notas_degustacao' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.exists' => 'A categoria escolhida não existe.',
            'nome.required' => 'Informe o nome do produto.',
            'nome.max' => 'O nome pode ter no máximo 100 caracteres.',
            'nome.unique' => 'Já existe um produto com esse nome.',
            'descricao.required' => 'Informe a descrição do produto.',
            'descricao.max' => 'A descrição pode ter no máximo 200 caracteres.',
            'preco_unitario.required' => 'Informe o preço.',
            'preco_unitario.numeric' => 'O preço deve ser um número.',
            'preco_unitario.min' => 'O preço deve ser maior que zero.',
            'estoque.integer' => 'O estoque deve ser um número inteiro.',
            'estoque.min' => 'O estoque não pode ser negativo.',
            'origem_grao.required_if' => 'Informe a origem do grão do café.',
            'origem_grao.max' => 'A origem do grão pode ter no máximo 50 caracteres.',
            'tipo_torra.required_if' => 'Informe o tipo de torra do café.',
            'tipo_torra.in' => 'O tipo de torra deve ser Clara, Média ou Forte.',
            'notas_degustacao.max' => 'As notas de degustação podem ter no máximo 50 caracteres.',
        ];
    }
}
