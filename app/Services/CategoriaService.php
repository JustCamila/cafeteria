<?php

namespace App\Services;

use App\Models\Categoria;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoriaService
{
    public function listar(?string $busca, int $porPagina = 10): LengthAwarePaginator
    {
        return Categoria::query()
            ->withCount('produtos')
            ->when($busca, fn ($query) => $query->where('nome', 'ilike', "%{$busca}%"))
            ->orderBy('nome')
            ->paginate($porPagina)
            ->withQueryString();
    }

    public function criar(array $dados): Categoria
    {
        return Categoria::create($dados);
    }

    public function atualizar(Categoria $categoria, array $dados): Categoria
    {
        $categoria->update($dados);

        return $categoria;
    }

    // a FK do produto é "on delete set null": os produtos continuam cadastrados, só ficam sem categoria
    public function excluir(Categoria $categoria): void
    {
        $categoria->delete();
    }
}
