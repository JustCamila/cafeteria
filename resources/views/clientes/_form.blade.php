@csrf

<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" id="nome" name="nome" maxlength="150" required
           class="form-control @error('nome') is-invalid @enderror"
           value="{{ old('nome', $cliente->nome) }}">
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" id="cpf" name="cpf" maxlength="14" required placeholder="000.000.000-00"
               class="form-control @error('cpf') is-invalid @enderror"
               value="{{ old('cpf', $cliente->cpf_formatado) }}">
        @error('cpf')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" id="telefone" name="telefone" maxlength="15" required placeholder="(00) 00000-0000"
               class="form-control @error('telefone') is-invalid @enderror"
               value="{{ old('telefone', $cliente->telefone_formatado) }}">
        @error('telefone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">E-mail</label>
    <input type="email" id="email" name="email" maxlength="100" required
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $cliente->email) }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-dark">Salvar</button>
<a href="{{ $cliente->exists ? route('clientes.show', $cliente) : route('clientes.index') }}" class="btn btn-link">Cancelar</a>
