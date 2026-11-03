<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePedidoRequest;
use App\Models\Pedido;
use App\Models\Produto;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use RuntimeException;

// o cadastro de pedido fica na tela "Registrar venda" (VendaController + sp_registrar_venda),
// por isso este controller não tem create/store
class PedidoController extends Controller
{
    public function __construct(private PedidoService $pedidoService)
    {
    }

    public function index(Request $request)
    {
        return view('pedidos.index', [
            'pedidos' => $this->pedidoService->listar($request->query('busca'), $request->query('forma_pagamento')),
            'busca' => $request->query('busca'),
            'formaPagamento' => $request->query('forma_pagamento'),
            'formasPagamento' => UpdatePedidoRequest::FORMAS_PAGAMENTO,
        ]);
    }

    public function show(Pedido $pedido)
    {
        return view('pedidos.show', ['pedido' => $this->pedidoService->carregar($pedido)]);
    }

    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit', [
            'pedido' => $this->pedidoService->carregar($pedido),
            'produtos' => Produto::orderBy('nome')->get(),
            'formasPagamento' => UpdatePedidoRequest::FORMAS_PAGAMENTO,
        ]);
    }

    public function update(UpdatePedidoRequest $request, Pedido $pedido)
    {
        try {
            $this->pedidoService->atualizar($pedido, $request->validated());
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('pedidos.show', $pedido)->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Pedido $pedido)
    {
        try {
            $this->pedidoService->excluir($pedido);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('pedidos.index')->with('success', "Pedido nº {$pedido->id_pedido} excluído. Os produtos voltaram para o estoque.");
    }
}
