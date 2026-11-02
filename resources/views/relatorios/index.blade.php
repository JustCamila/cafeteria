@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
    <h1>Relatórios</h1>

    <div class="card card-body mb-4">
        <h5>Produtos mais vendidos</h5>

        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade vendida</th>
                    <th>Faturamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->produto }}</td>
                        <td>{{ $produto->quantidade_vendida }}</td>
                        <td>R$ {{ number_format($produto->faturamento, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card card-body mb-4">
        <h5>Resumo do cliente</h5>

        <form action="{{ route('relatorios.index') }}" method="GET" class="row g-2 mb-3">
            <div class="col-auto">
                <input type="text" name="cpf" class="form-control" maxlength="11" placeholder="CPF" value="{{ $cpf }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-dark">Buscar</button>
            </div>
        </form>

        @if ($resumo)
            <p class="mb-1"><strong>Cliente:</strong> {{ $resumo->nome_cliente }}</p>
            <p class="mb-1"><strong>Total de pedidos:</strong> {{ $resumo->total_pedidos }}</p>
            <p class="mb-1"><strong>Total gasto:</strong> R$ {{ number_format($resumo->total_gasto, 2, ',', '.') }}</p>
            <p class="mb-0"><strong>Último pedido:</strong> {{ $resumo->ultimo_pedido ? \Carbon\Carbon::parse($resumo->ultimo_pedido)->format('d/m/Y H:i') : '-' }}</p>
        @elseif ($cpf)
            <p class="mb-0">Cliente não encontrado.</p>
        @endif
    </div>
@endsection
