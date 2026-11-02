@extends('layouts.app')

@section('title', 'Registrar venda')

@section('content')
    <h1>Registrar venda</h1>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card card-body">
                <form action="{{ route('vendas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">CPF do cliente (opcional)</label>
                        <input type="text" name="cpf" class="form-control" maxlength="11" value="{{ old('cpf') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Forma de pagamento</label>
                        <select name="forma_pagamento" class="form-select">
                            @foreach (['Cartão de Crédito', 'Cartão de Débito', 'Pix', 'Dinheiro'] as $forma)
                                <option value="{{ $forma }}" @selected(old('forma_pagamento') == $forma)>{{ $forma }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr>
                                    <td>{{ $produto->nome }}</td>
                                    <td>R$ {{ number_format($produto->preco_unitario, 2, ',', '.') }}</td>
                                    <td>{{ $produto->estoque }}</td>
                                    <td>
                                        <input type="number" name="quantidades[{{ $produto->id_produto }}]" class="form-control" min="0" value="{{ old('quantidades.' . $produto->id_produto) }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-dark">Registrar venda</button>
                </form>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card card-body">
                <h5>Repor estoque</h5>

                <form action="{{ route('vendas.repor') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Produto</label>
                        <select name="produto_id" class="form-select">
                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id_produto }}">{{ $produto->nome }} (estoque: {{ $produto->estoque }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantidade</label>
                        <input type="number" name="quantidade" class="form-control" min="1" value="1">
                    </div>

                    <button type="submit" class="btn btn-outline-dark">Repor</button>
                </form>
            </div>
        </div>
    </div>
@endsection
