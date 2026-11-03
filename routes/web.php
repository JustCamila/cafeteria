<?php

use Illuminate\Support\Facades\Route;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;

Route::get('/', fn () => view('home', [
    'produtos' => Produto::count(),
    'clientes' => Cliente::count(),
    'pedidos'  => Pedido::count(),
]));

Route::get('/vendas/registrar', [VendaController::class, 'create'])->name('vendas.create');
Route::post('/vendas', [VendaController::class, 'store'])->name('vendas.store');
Route::post('/vendas/repor-estoque', [VendaController::class, 'reporEstoque'])->name('vendas.repor');
Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');

// CRUDs (Resource Controllers)
// os nomes dos parâmetros são definidos na mão para bater com o route model binding,
// e só aceitam números: assim /pedidos/abc dá 404 em vez de erro no PostgreSQL
Route::pattern('categoria', '[0-9]+');
Route::pattern('cliente', '[0-9]+');
Route::pattern('produto', '[0-9]+');
Route::pattern('pedido', '[0-9]+');

Route::resource('categorias', CategoriaController::class)->parameters(['categorias' => 'categoria']);
Route::resource('clientes', ClienteController::class)->parameters(['clientes' => 'cliente']);
Route::resource('produtos', ProdutoController::class)->parameters(['produtos' => 'produto']);

// pedido novo é registrado pela tela de vendas (procedure sp_registrar_venda)
Route::resource('pedidos', PedidoController::class)
    ->parameters(['pedidos' => 'pedido'])
    ->except(['create', 'store']);
