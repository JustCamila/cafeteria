<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Services\VendaService;
use Illuminate\Http\Request;
use RuntimeException;

class VendaController extends Controller
{
    public function __construct(private VendaService $vendaService)
    {
    }

    public function create()
    {
        return view('vendas.create', [
            'produtos' => Produto::orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->merge(['cpf' => preg_replace('/\D/', '', (string) $request->input('cpf')) ?: null]);

        $dados = $request->validate([
            'cpf' => 'nullable|digits:11',
            'forma_pagamento' => 'required|in:Cartão de Crédito,Cartão de Débito,Pix,Dinheiro',
            'quantidades' => 'required|array',
            'quantidades.*' => 'nullable|integer|min:0',
        ], [
            'cpf.digits' => 'O CPF deve ter 11 números.',
            'quantidades.*.min' => 'A quantidade não pode ser negativa.',
        ]);

        try {
            $this->vendaService->registrarVenda(
                $dados['cpf'] ?? null,
                $dados['forma_pagamento'],
                array_filter($dados['quantidades'])
            );
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('vendas.create')->with('success', 'Venda registrada com sucesso.');
    }

    public function reporEstoque(Request $request)
    {
        $dados = $request->validate([
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer|min:1',
        ], [
            'quantidade.min' => 'A quantidade deve ser maior que zero.',
        ]);

        try {
            $this->vendaService->reporEstoque($dados['produto_id'], $dados['quantidade']);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('vendas.create')->with('success', 'Estoque atualizado com sucesso.');
    }
}
