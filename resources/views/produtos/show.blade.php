@extends('layouts.app')

@section('title', $produto->nome)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">{{ $produto->nome }}</h1>
        <div class="text-nowrap">
            <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-outline-primary">Editar</a>
            @include('partials.botao-excluir', [
                'acao' => route('produtos.destroy', $produto),
                'mensagem' => "Excluir o produto {$produto->nome}?",
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card card-body h-100">
                <h5>Dados do produto</h5>
                <p class="mb-1"><strong>Categoria:</strong> {{ $produto->categoria?->nome ?? 'Sem categoria' }}</p>
                <p class="mb-1"><strong>Descrição:</strong> {{ $produto->descricao }}</p>
                <p class="mb-1"><strong>Preço:</strong> R$ {{ number_format($produto->preco_unitario, 2, ',', '.') }}</p>
                <p class="mb-0">
                    <strong>Estoque:</strong> @include('produtos._estoque', ['estoque' => $produto->estoque])
                    <a href="{{ route('vendas.create') }}" class="ms-2 small">Repor estoque</a>
                </p>

                @if ($produto->detalheCafe)
                    <hr>
                    <h6>Detalhes do café</h6>
                    <p class="mb-1"><strong>Origem do grão:</strong> {{ $produto->detalheCafe->origem_grao }}</p>
                    <p class="mb-1"><strong>Torra:</strong> {{ $produto->detalheCafe->tipo_torra }}</p>
                    <p class="mb-0"><strong>Notas de degustação:</strong> {{ $produto->detalheCafe->notas_degustacao ?? '-' }}</p>
                @endif
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card card-body h-100">
                <h5>Vendas</h5>
                <p class="mb-1"><strong>Unidades vendidas:</strong> {{ $vendas->quantidade }}</p>
                <p class="mb-0"><strong>Faturamento:</strong> R$ {{ number_format($vendas->faturamento, 2, ',', '.') }}</p>

                @if ($vendas->quantidade == 0)
                    <p class="text-muted small mt-2 mb-0">Este produto nunca foi vendido.</p>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('produtos.index') }}" class="btn btn-link px-0">&larr; Voltar para produtos</a>
@endsection
