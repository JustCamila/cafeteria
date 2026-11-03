@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
    <h1>Editar cliente</h1>

    <div class="card card-body col-lg-8">
        <form action="{{ route('clientes.update', $cliente) }}" method="POST">
            @method('PUT')
            @include('clientes._form')
        </form>
    </div>
@endsection
