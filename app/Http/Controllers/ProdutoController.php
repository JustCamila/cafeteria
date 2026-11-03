<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Categoria;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use RuntimeException;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoService $produtoService)
    {
    }

    public function index(Request $request)
    {
        $categoriaId = $request->integer('categoria_id') ?: null;

        return view('produtos.index', [
            'produtos' => $this->produtoService->listar($request->query('busca'), $categoriaId),
            'categorias' => Categoria::orderBy('nome')->get(),
            'busca' => $request->query('busca'),
            'categoriaId' => $categoriaId,
        ]);
    }

    public function create()
    {
        return view('produtos.create', [
            'produto' => new Produto(),
            'categorias' => Categoria::orderBy('nome')->get(),
        ]);
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = $this->produtoService->criar($request->validated());

        return redirect()->route('produtos.show', $produto)->with('success', 'Produto cadastrado com sucesso.');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', [
            'produto' => $produto->load('categoria', 'detalheCafe'),
            'vendas' => $this->produtoService->resumoVendas($produto),
        ]);
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', [
            'produto' => $produto->load('detalheCafe'),
            'categorias' => Categoria::orderBy('nome')->get(),
        ]);
    }

    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $this->produtoService->atualizar($produto, $request->validated());

        return redirect()->route('produtos.show', $produto)->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        try {
            $this->produtoService->excluir($produto);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso.');
    }
}
