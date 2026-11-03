@csrf

@php
    $detalhe = $produto->detalheCafe;
    $ehCafe = (bool) old('eh_cafe', $detalhe !== null);
@endphp

<div class="row">
    <div class="col-md-8 mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" id="nome" name="nome" maxlength="100" required
               class="form-control @error('nome') is-invalid @enderror"
               value="{{ old('nome', $produto->nome) }}">
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="categoria_id" class="form-label">Categoria</label>
        <select id="categoria_id" name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror">
            <option value="">Sem categoria</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}" @selected(old('categoria_id', $produto->categoria_id) == $categoria->id_categoria)>{{ $categoria->nome }}</option>
            @endforeach
        </select>
        @error('categoria_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="descricao" class="form-label">Descrição</label>
    <input type="text" id="descricao" name="descricao" maxlength="200" required
           class="form-control @error('descricao') is-invalid @enderror"
           value="{{ old('descricao', $produto->descricao) }}">
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="preco_unitario" class="form-label">Preço (R$)</label>
        <input type="text" id="preco_unitario" name="preco_unitario" required inputmode="decimal" placeholder="0,00"
               class="form-control @error('preco_unitario') is-invalid @enderror"
               value="{{ old('preco_unitario', $produto->exists ? number_format($produto->preco_unitario, 2, ',', '') : '') }}">
        @error('preco_unitario')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="estoque" class="form-label">Estoque</label>
        @if ($produto->exists)
            {{-- depois do cadastro o estoque só muda por venda (trigger) ou reposição (procedure) --}}
            <input type="text" id="estoque" class="form-control" value="{{ $produto->estoque }}" disabled>
            <div class="form-text">Para aumentar, use <a href="{{ route('vendas.create') }}">Repor estoque</a>.</div>
        @else
            <input type="number" id="estoque" name="estoque" min="0"
                   class="form-control @error('estoque') is-invalid @enderror"
                   value="{{ old('estoque', 0) }}">
            @error('estoque')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        @endif
    </div>
</div>

<div class="form-check mb-3">
    {{-- o hidden garante que eh_cafe=0 seja enviado quando o checkbox fica desmarcado --}}
    <input type="hidden" name="eh_cafe" value="0">
    <input type="checkbox" id="eh_cafe" name="eh_cafe" value="1" class="form-check-input" @checked($ehCafe)>
    <label for="eh_cafe" class="form-check-label">É um café especial (tem origem do grão e torra)</label>
</div>

<fieldset id="detalhe-cafe" class="border rounded p-3 mb-3" @if (! $ehCafe) hidden @endif>
    <legend class="fs-6 w-auto px-2 mb-0">Detalhes do café</legend>

    <div class="row">
        <div class="col-md-5 mb-3">
            <label for="origem_grao" class="form-label">Origem do grão</label>
            <input type="text" id="origem_grao" name="origem_grao" maxlength="50" placeholder="Ex.: Sul de Minas - Brasil"
                   class="form-control @error('origem_grao') is-invalid @enderror"
                   value="{{ old('origem_grao', $detalhe?->origem_grao) }}">
            @error('origem_grao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3 mb-3">
            <label for="tipo_torra" class="form-label">Torra</label>
            <select id="tipo_torra" name="tipo_torra" class="form-select @error('tipo_torra') is-invalid @enderror">
                <option value="">Escolha</option>
                @foreach (['Clara', 'Média', 'Forte'] as $torra)
                    <option value="{{ $torra }}" @selected(old('tipo_torra', $detalhe?->tipo_torra) === $torra)>{{ $torra }}</option>
                @endforeach
            </select>
            @error('tipo_torra')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="notas_degustacao" class="form-label">Notas de degustação</label>
            <input type="text" id="notas_degustacao" name="notas_degustacao" maxlength="50" placeholder="Ex.: Caramelo"
                   class="form-control @error('notas_degustacao') is-invalid @enderror"
                   value="{{ old('notas_degustacao', $detalhe?->notas_degustacao) }}">
            @error('notas_degustacao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</fieldset>

<button type="submit" class="btn btn-dark">Salvar</button>
<a href="{{ $produto->exists ? route('produtos.show', $produto) : route('produtos.index') }}" class="btn btn-link">Cancelar</a>

@push('scripts')
    <script>
        // mostra os campos do café só quando o checkbox está marcado
        document.getElementById('eh_cafe').addEventListener('change', function () {
            document.getElementById('detalhe-cafe').hidden = !this.checked;
        });
    </script>
@endpush
