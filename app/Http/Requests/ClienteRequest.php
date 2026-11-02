<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// usado tanto no cadastro quanto na edição do cliente
class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // o usuário pode digitar CPF e telefone com máscara, mas no banco ficam só os números
    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', (string) $this->input('cpf')),
            'telefone' => preg_replace('/\D/', '', (string) $this->input('telefone')),
            'email' => mb_strtolower(trim((string) $this->input('email'))),
        ]);
    }

    public function rules(): array
    {
        $cliente = $this->route('cliente');

        return [
            'nome' => 'required|string|max:150',
            'cpf' => [
                'required',
                'digits:11',
                Rule::unique('cliente', 'cpf')->ignore($cliente, 'id_cliente'),
            ],
            'telefone' => 'required|digits_between:10,11',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('cliente', 'email')->ignore($cliente, 'id_cliente'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do cliente.',
            'nome.max' => 'O nome pode ter no máximo 150 caracteres.',
            'cpf.required' => 'Informe o CPF.',
            'cpf.digits' => 'O CPF deve ter 11 números.',
            'cpf.unique' => 'Já existe um cliente com esse CPF.',
            'telefone.required' => 'Informe o telefone.',
            'telefone.digits_between' => 'O telefone deve ter DDD e 8 ou 9 números.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail pode ter no máximo 100 caracteres.',
            'email.unique' => 'Já existe um cliente com esse e-mail.',
        ];
    }
}
