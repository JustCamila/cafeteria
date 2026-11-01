<?php

use Illuminate\Support\Facades\Route;
use App\Models\Produto;
use App\Models\Cliente;     
use App\Models\Pedido;

Route::get('/', fn () => view('home', [
    'produtos' => Produto::count(),
    'clientes' => Cliente::count(),
    'pedidos'  => Pedido::count(),
]));
