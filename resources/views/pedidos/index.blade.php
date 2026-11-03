@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Pedidos</h1>
        {{-- pedido novo é registrado pela tela de vendas, que usa a procedure sp_registrar_venda --}}
        <a href="{{ route('vendas.create') }}" class="btn btn-dark">Novo pedido</a>
    </div>

    <form action="{{ route('pedidos.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input type="text" name="busca" class="form-control" placeholder="Nº do pedido ou CPF do cliente" value="{{ $busca }}">
        </div>
        <div class="col-sm-6 col-md-3">
            <select name="forma_pagamento" class="form-select">
                <option value="">Todas as formas de pagamento</option>
                @foreach ($formasPagamento as $forma)
                    <option value="{{ $forma }}" @selected($formaPagamento === $forma)>{{ $forma }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-dark">Filtrar</button>
            @if ($busca || $formaPagamento)
                <a href="{{ route('pedidos.index') }}" class="btn btn-link">Limpar</a>
            @endif
        </div>
    </form>

    <div class="card card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Itens</th>
                        <th>Pagamento</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr>
                            <td><a href="{{ route('pedidos.show', $pedido) }}">{{ $pedido->id_pedido }}</a></td>
                            <td class="text-nowrap">{{ $pedido->data_hora->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($pedido->cliente)
                                    <a href="{{ route('clientes.show', $pedido->cliente) }}">{{ $pedido->cliente->nome }}</a>
                                @else
                                    <span class="text-muted">Não identificado</span>
                                @endif
                            </td>
                            <td>{{ $pedido->itens_count }}</td>
                            <td>{{ $pedido->forma_pagamento }}</td>
                            <td class="text-end text-nowrap">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                @include('partials.botao-excluir', [
                                    'acao' => route('pedidos.destroy', $pedido),
                                    'mensagem' => "Excluir o pedido nº {$pedido->id_pedido}? Os produtos voltam para o estoque.",
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $pedidos->links() }}</div>
@endsection
