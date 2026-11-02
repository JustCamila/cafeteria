@extends('layouts.app')

@section('title', 'Novo cliente')

@section('content')
    <h1>Novo cliente</h1>

    <div class="card card-body col-lg-8">
        <form action="{{ route('clientes.store') }}" method="POST">
            @include('clientes._form')
        </form>
    </div>
@endsection
