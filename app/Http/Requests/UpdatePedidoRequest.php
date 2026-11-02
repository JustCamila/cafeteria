<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

// edição do pedido: cliente, forma de pagamento, quantidades dos itens e produtos novos
// o cadastro de pedido é feito pela tela de vendas (procedure sp_registrar_venda)
class UpdatePedidoRequest extends FormRequest
{
    public const FORMAS_PAGAMENTO = ['Cartão de Crédito', 'Cartão de Débito', 'Pix', 'Dinheiro'];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['cpf' => preg_replace('/\D/', '', (string) $this->input('cpf')) ?: null]);
    }

    public function rules(): array
    {
        return [
            'cpf' => 'nullable|digits:11|exists:cliente,cpf',
            'forma_pagamento' => 'required|in:' . implode(',', self::FORMAS_PAGAMENTO),

            // itens que já estão no pedido: [id_itens_pedido => quantidade], 0 remove o item
            'itens' => 'nullable|array',
            'itens.*' => 'nullable|integer|min:0',

            // produtos adicionados: [id_produto => quantidade]
            'novos' => 'nullable|array',
            'novos.*' => 'nullable|integer|min:0',
        ];
    }

    // o pedido não pode ficar sem nenhum item
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $total = array_sum(array_map('intval', (array) $this->input('itens', [])))
                       + array_sum(array_map('intval', (array) $this->input('novos', [])));

                if ($total === 0) {
                    $validator->errors()->add('itens', 'O pedido precisa ter pelo menos um item.');
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.digits' => 'O CPF deve ter 11 números.',
            'cpf.exists' => 'Nenhum cliente cadastrado com esse CPF.',
            'forma_pagamento.required' => 'Escolha a forma de pagamento.',
            'forma_pagamento.in' => 'Forma de pagamento inválida.',
            'itens.*.integer' => 'A quantidade deve ser um número inteiro.',
            'itens.*.min' => 'A quantidade não pode ser negativa.',
            'novos.*.integer' => 'A quantidade deve ser um número inteiro.',
            'novos.*.min' => 'A quantidade não pode ser negativa.',
        ];
    }
}
