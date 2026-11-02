@csrf

<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" id="nome" name="nome" maxlength="100" required
           class="form-control @error('nome') is-invalid @enderror"
           value="{{ old('nome', $categoria->nome) }}">
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-dark">Salvar</button>
<a href="{{ route('categorias.index') }}" class="btn btn-link">Cancelar</a>
