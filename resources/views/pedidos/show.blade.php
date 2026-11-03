@extends('layouts.app')

@section('title', "Pedido nº {$pedido->id_pedido}")

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Pedido nº {{ $pedido->id_pedido }}</h1>
        <div class="text-nowrap">
            <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-sm btn-outline-primary">Editar</a>
            @include('partials.botao-excluir', [
                'acao' => route('pedidos.destroy', $pedido),
                'mensagem' => "Excluir o pedido nº {$pedido->id_pedido}? Os produtos voltam para o estoque.",
            ])
        </div>
    </div>

    <div class="card card-body mb-4">
        <div class="row">
            <div class="col-md-3"><strong>Data:</strong> {{ $pedido->data_hora->format('d/m/Y H:i') }}</div>
            <div class="col-md-4">
                <strong>Cliente:</strong>
                @if ($pedido->cliente)
                    <a href="{{ route('clientes.show', $pedido->cliente) }}">{{ $pedido->cliente->nome }}</a>
                    ({{ $pedido->cliente->cpf_formatado }})
                @else
                    <span class="text-muted">Não identificado</span>
                @endif
            </div>
            <div class="col-md-3"><strong>Pagamento:</strong> {{ $pedido->forma_pagamento }}</div>
            <div class="col-md-2"><strong>Itens:</strong> {{ $pedido->itens->count() }}</div>
        </div>
    </div>

    <div class="card card-body">
        <h5>Itens do pedido</h5>

        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th class="text-end">Quantidade</th>
                    <th class="text-end">Preço unitário</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->itens as $item)
                    <tr>
                        <td><a href="{{ route('produtos.show', $item->produto) }}">{{ $item->produto->nome }}</a></td>
                        <td class="text-end">{{ $item->quantidade }}</td>
                        <td class="text-end">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                        <td class="text-end">R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    {{-- o total vem da coluna valor_total, que a trigger trg_atualizar_valor_total mantém atualizada --}}
                    <th colspan="3" class="text-end">Total</th>
                    <th class="text-end">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <a href="{{ route('pedidos.index') }}" class="btn btn-link mt-3 px-0">&larr; Voltar para pedidos</a>
@endsection
