<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $clienteService)
    {
    }

    public function index(Request $request)
    {
        return view('clientes.index', [
            'clientes' => $this->clienteService->listar($request->query('busca')),
            'busca' => $request->query('busca'),
        ]);
    }

    public function create()
    {
        return view('clientes.create', ['cliente' => new Cliente()]);
    }

    public function store(ClienteRequest $request)
    {
        $cliente = $this->clienteService->criar($request->validated());

        return redirect()->route('clientes.show', $cliente)->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', [
            'cliente' => $cliente,
            'pedidos' => $this->clienteService->historicoPedidos($cliente),
        ]);
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', ['cliente' => $cliente]);
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $this->clienteService->atualizar($cliente, $request->validated());

        return redirect()->route('clientes.show', $cliente)->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Cliente $cliente)
    {
        $this->clienteService->excluir($cliente);

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso.');
    }
}
