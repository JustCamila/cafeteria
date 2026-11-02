@extends('layouts.app')

@section('title', 'Editar categoria')

@section('content')
    <h1>Editar categoria</h1>

    <div class="card card-body col-lg-6">
        <form action="{{ route('categorias.update', $categoria) }}" method="POST">
            @method('PUT')
            @include('categorias._form')
        </form>
    </div>
@endsection
