<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// usado tanto no cadastro quanto na edição: na edição o unique ignora a própria categoria
class CategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['nome' => trim((string) $this->input('nome'))]);
    }

    public function rules(): array
    {
        return [
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categoria', 'nome')->ignore($this->route('categoria'), 'id_categoria'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome da categoria.',
            'nome.max' => 'O nome da categoria pode ter no máximo 100 caracteres.',
            'nome.unique' => 'Já existe uma categoria com esse nome.',
        ];
    }
}
