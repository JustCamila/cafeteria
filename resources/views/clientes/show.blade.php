@extends('layouts.app')

@section('title', $cliente->nome)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">{{ $cliente->nome }}</h1>
        <div class="text-nowrap">
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-primary">Editar</a>
            @include('partials.botao-excluir', [
                'acao' => route('clientes.destroy', $cliente),
                'mensagem' => "Excluir o cliente {$cliente->nome}? Os pedidos dele continuam no sistema, mas sem cliente.",
            ])
        </div>
    </div>

    <div class="card card-body mb-4">
        <div class="row">
            <div class="col-md-4"><strong>CPF:</strong> {{ $cliente->cpf_formatado }}</div>
            <div class="col-md-4"><strong>Telefone:</strong> {{ $cliente->telefone_formatado }}</div>
            <div class="col-md-4"><strong>E-mail:</strong> {{ $cliente->email }}</div>
        </div>
    </div>

    <div class="card card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Histórico de pedidos ({{ $pedidos->total() }})</h5>
            <a href="{{ route('relatorios.index', ['cpf' => $cliente->cpf]) }}" class="btn btn-sm btn-outline-dark">Ver resumo do cliente</a>
        </div>

        @if ($pedidos->isEmpty())
            <p class="text-muted mb-0">Este cliente ainda não fez pedidos.</p>
        @else
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Data</th>
                        <th>Pagamento</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td><a href="{{ route('pedidos.show', $pedido) }}">{{ $pedido->id_pedido }}</a></td>
                            <td>{{ $pedido->data_hora->format('d/m/Y H:i') }}</td>
                            <td>{{ $pedido->forma_pagamento }}</td>
                            <td class="text-end">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">{{ $pedidos->links() }}</div>
        @endif
    </div>

    <a href="{{ route('clientes.index') }}" class="btn btn-link mt-3 px-0">&larr; Voltar para clientes</a>
@endsection
