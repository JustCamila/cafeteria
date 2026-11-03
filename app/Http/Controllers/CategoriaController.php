<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use App\Services\CategoriaService;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct(private CategoriaService $categoriaService)
    {
    }

    public function index(Request $request)
    {
        return view('categorias.index', [
            'categorias' => $this->categoriaService->listar($request->query('busca')),
            'busca' => $request->query('busca'),
        ]);
    }

    public function create()
    {
        return view('categorias.create', ['categoria' => new Categoria()]);
    }

    public function store(CategoriaRequest $request)
    {
        $categoria = $this->categoriaService->criar($request->validated());

        return redirect()->route('categorias.show', $categoria)->with('success', 'Categoria cadastrada com sucesso.');
    }

    public function show(Categoria $categoria)
    {
        return view('categorias.show', [
            'categoria' => $categoria,
            'produtos' => $categoria->produtos()->orderBy('nome')->get(),
        ]);
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', ['categoria' => $categoria]);
    }

    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $this->categoriaService->atualizar($categoria, $request->validated());

        return redirect()->route('categorias.show', $categoria)->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy(Categoria $categoria)
    {
        $this->categoriaService->excluir($categoria);

        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso.');
    }
}
