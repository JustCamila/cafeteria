@extends('layouts.app')

@section('title', 'Novo produto')

@section('content')
    <h1>Novo produto</h1>

    <div class="card card-body col-lg-9">
        <form action="{{ route('produtos.store') }}" method="POST">
            @include('produtos._form')
        </form>
    </div>
@endsection
