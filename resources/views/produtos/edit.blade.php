@extends('layouts.app')

@section('title', 'Editar produto')

@section('content')
    <h1>Editar produto</h1>

    <div class="card card-body col-lg-9">
        <form action="{{ route('produtos.update', $produto) }}" method="POST">
            @method('PUT')
            @include('produtos._form')
        </form>
    </div>
@endsection
