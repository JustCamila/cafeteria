@extends('layouts.app')

@section('content')
    <h1>Painel</h1>
    <div class="row">
        <div class="col"><div class="card card-body">Produtos: {{ $produtos }}</div></div>
        <div class="col"><div class="card card-body">Clientes: {{ $clientes }}</div></div>
        <div class="col"><div class="card card-body">Pedidos: {{ $pedidos }}</div></div>
    </div>
@endsection