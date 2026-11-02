@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Produtos</h1>
        <a href="{{ route('produtos.create') }}" class="btn btn-dark">Novo produto</a>
    </div>

    <form action="{{ route('produtos.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input type="text" name="busca" class="form-control" placeholder="Buscar pelo nome" value="{{ $busca }}">
        </div>
        <div class="col-sm-6 col-md-3">
            <select name="categoria_id" class="form-select">
                <option value="">Todas as categorias</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" @selected($categoriaId == $categoria->id_categoria)>{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-dark">Filtrar</button>
            @if ($busca || $categoriaId)
                <a href="{{ route('produtos.index') }}" class="btn btn-link">Limpar</a>
            @endif
        </div>
    </form>

    <div class="card card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produtos as $produto)
                        <tr>
                            <td><a href="{{ route('produtos.show', $produto) }}">{{ $produto->nome }}</a></td>
                            <td>{{ $produto->categoria?->nome ?? 'Sem categoria' }}</td>
                            <td class="text-nowrap">R$ {{ number_format($produto->preco_unitario, 2, ',', '.') }}</td>
                            <td>
                                @include('produtos._estoque', ['estoque' => $produto->estoque])
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('produtos.show', $produto) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                @include('partials.botao-excluir', [
                                    'acao' => route('produtos.destroy', $produto),
                                    'mensagem' => "Excluir o produto {$produto->nome}?",
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nenhum produto encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $produtos->links() }}</div>
@endsection
