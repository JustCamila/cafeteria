<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Http\Resources\ProdutoResource;
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

        return ProdutoResource::collection(
            $this->produtoService->listar($request->query('busca'), $categoriaId)
        );
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = $this->produtoService->criar($request->validated());

        return (new ProdutoResource($produto->load('categoria', 'detalheCafe')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Produto $produto)
    {
        return (new ProdutoResource($produto->load('categoria', 'detalheCafe')))
            ->additional(['vendas' => $this->produtoService->resumoVendas($produto)]);
    }

    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $produto = $this->produtoService->atualizar($produto, $request->validated());

        return new ProdutoResource($produto->load('categoria', 'detalheCafe'));
    }

    public function destroy(Produto $produto)
    {
        try {
            $this->produtoService->excluir($produto);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }

        return response()->noContent();
    }
}