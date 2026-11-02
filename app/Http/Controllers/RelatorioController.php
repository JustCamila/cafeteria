<?php

namespace App\Http\Controllers;

use App\Services\RelatorioService;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function __construct(private RelatorioService $relatorioService)
    {
    }

    public function index(Request $request)
    {
        $request->merge(['cpf' => preg_replace('/\D/', '', (string) $request->input('cpf')) ?: null]);

        $dados = $request->validate([
            'cpf' => 'nullable|digits:11',
        ], [
            'cpf.digits' => 'O CPF deve ter 11 números.',
        ]);

        $cpf = $dados['cpf'] ?? null;

        return view('relatorios.index', [
            'produtos' => $this->relatorioService->produtosMaisVendidos(5),
            'cpf' => $cpf,
            'resumo' => $cpf ? $this->relatorioService->resumoCliente($cpf) : null,
        ]);
    }
}
