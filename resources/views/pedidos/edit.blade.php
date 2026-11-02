@extends('layouts.app')

@section('title', "Editar pedido nº {$pedido->id_pedido}")

@section('content')
    <h1>Editar pedido nº {{ $pedido->id_pedido }}</h1>

    <div class="alert alert-info">
        O estoque é ajustado automaticamente pelo banco: ao diminuir ou remover um item os produtos voltam
        para o estoque, e ao aumentar ou adicionar eles são baixados. Se não houver estoque suficiente, nada é salvo.
    </div>

    <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card card-body mb-4">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="cpf" class="form-label">CPF do cliente (opcional)</label>
                    <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="000.000.000-00"
                           class="form-control @error('cpf') is-invalid @enderror"
                           value="{{ old('cpf', $pedido->cliente?->cpf_formatado) }}">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($pedido->cliente)
                        <div class="form-text">Atual: {{ $pedido->cliente->nome }}. Deixe em branco para pedido sem cliente.</div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="forma_pagamento" class="form-label">Forma de pagamento</label>
                    <select id="forma_pagamento" name="forma_pagamento" class="form-select @error('forma_pagamento') is-invalid @enderror">
                        @foreach ($formasPagamento as $forma)
                            <option value="{{ $forma }}" @selected(old('forma_pagamento', $pedido->forma_pagamento) === $forma)>{{ $forma }}</option>
                        @endforeach
                    </select>
                    @error('forma_pagamento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card card-body mb-4">
            <h5>Itens do pedido</h5>
            <p class="text-muted small">Para remover um item, coloque a quantidade 0.</p>

            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço unitário</th>
                        <th>Estoque atual</th>
                        <th style="width: 140px">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedido->itens as $item)
                        <tr>
                            <td>{{ $item->produto->nome }}</td>
                            <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                            <td>{{ $item->produto->estoque }}</td>
                            <td>
                                <input type="number" name="itens[{{ $item->id_itens_pedido }}]" min="0" class="form-control"
                                       value="{{ old('itens.' . $item->id_itens_pedido, $item->quantidade) }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card card-body mb-4">
            <h5>Adicionar produtos</h5>
            <p class="text-muted small">Os produtos novos entram com o preço atual do cadastro.</p>

            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th style="width: 140px">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->nome }}</td>
                            <td>R$ {{ number_format($produto->preco_unitario, 2, ',', '.') }}</td>
                            <td>@include('produtos._estoque', ['estoque' => $produto->estoque])</td>
                            <td>
                                <input type="number" name="novos[{{ $produto->id_produto }}]" min="0" class="form-control"
                                       value="{{ old('novos.' . $produto->id_produto) }}" @disabled($produto->estoque <= 0)>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-dark">Salvar alterações</button>
        <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-link">Cancelar</a>
    </form>
@endsection
