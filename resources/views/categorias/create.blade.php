@extends('layouts.app')

@section('title', 'Nova categoria')

@section('content')
    <h1>Nova categoria</h1>

    <div class="card card-body col-lg-6">
        <form action="{{ route('categorias.store') }}" method="POST">
            @include('categorias._form')
        </form>
    </div>
@endsection
