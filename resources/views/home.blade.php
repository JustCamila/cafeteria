@extends('layouts.app')

@section('content')
    <h1>Painel</h1>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('produtos.index') }}" class="card card-body text-decoration-none text-reset h-100">
                <span class="text-muted">Produtos</span>
                <span class="fs-3 fw-semibold">{{ number_format($produtos, 0, ',', '.') }}</span>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('clientes.index') }}" class="card card-body text-decoration-none text-reset h-100">
                <span class="text-muted">Clientes</span>
                <span class="fs-3 fw-semibold">{{ number_format($clientes, 0, ',', '.') }}</span>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('pedidos.index') }}" class="card card-body text-decoration-none text-reset h-100">
                <span class="text-muted">Pedidos</span>
                <span class="fs-3 fw-semibold">{{ number_format($pedidos, 0, ',', '.') }}</span>
            </a>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('vendas.create') }}" class="btn btn-dark">Registrar venda</a>
        <a href="{{ route('relatorios.index') }}" class="btn btn-outline-dark">Ver relatórios</a>
    </div>
@endsection
