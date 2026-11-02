@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-dark">Novo cliente</a>
    </div>

    <form action="{{ route('clientes.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-5">
            <input type="text" name="busca" class="form-control" placeholder="Buscar por nome, e-mail ou CPF" value="{{ $busca }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-dark">Buscar</button>
            @if ($busca)
                <a href="{{ route('clientes.index') }}" class="btn btn-link">Limpar</a>
            @endif
        </div>
    </form>

    <div class="card card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td><a href="{{ route('clientes.show', $cliente) }}">{{ $cliente->nome }}</a></td>
                            <td class="text-nowrap">{{ $cliente->cpf_formatado }}</td>
                            <td class="text-nowrap">{{ $cliente->telefone_formatado }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                @include('partials.botao-excluir', [
                                    'acao' => route('clientes.destroy', $cliente),
                                    'mensagem' => "Excluir o cliente {$cliente->nome}? Os pedidos dele continuam no sistema, mas sem cliente.",
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nenhum cliente encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $clientes->links() }}</div>
@endsection
