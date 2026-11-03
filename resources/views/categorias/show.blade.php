@extends('layouts.app')

@section('title', $categoria->nome)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">{{ $categoria->nome }}</h1>
        <div class="text-nowrap">
            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-primary">Editar</a>
            @include('partials.botao-excluir', [
                'acao' => route('categorias.destroy', $categoria),
                'mensagem' => "Excluir a categoria {$categoria->nome}? Os produtos dela ficarão sem categoria.",
            ])
        </div>
    </div>

    <div class="card card-body">
        <h5>Produtos da categoria ({{ $produtos->count() }})</h5>

        @if ($produtos->isEmpty())
            <p class="text-muted mb-0">Nenhum produto nesta categoria.</p>
        @else
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td><a href="{{ route('produtos.show', $produto) }}">{{ $produto->nome }}</a></td>
                            <td>R$ {{ number_format($produto->preco_unitario, 2, ',', '.') }}</td>
                            <td>{{ $produto->estoque }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <a href="{{ route('categorias.index') }}" class="btn btn-link mt-3 px-0">&larr; Voltar para categorias</a>
@endsection
