@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Categorias</h1>
        <a href="{{ route('categorias.create') }}" class="btn btn-dark">Nova categoria</a>
    </div>

    <form action="{{ route('categorias.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input type="text" name="busca" class="form-control" placeholder="Buscar pelo nome" value="{{ $busca }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-dark">Buscar</button>
            @if ($busca)
                <a href="{{ route('categorias.index') }}" class="btn btn-link">Limpar</a>
            @endif
        </div>
    </form>

    <div class="card card-body">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Produtos</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td><a href="{{ route('categorias.show', $categoria) }}">{{ $categoria->nome }}</a></td>
                        <td>{{ $categoria->produtos_count }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            @include('partials.botao-excluir', [
                                'acao' => route('categorias.destroy', $categoria),
                                'mensagem' => "Excluir a categoria {$categoria->nome}? Os produtos dela ficarão sem categoria.",
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Nenhuma categoria encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $categorias->links() }}</div>
@endsection
