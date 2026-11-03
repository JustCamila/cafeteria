<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cafeteria Gourmet')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">☕ Cafeteria Gourmet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                    aria-controls="menu" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- o link da tela atual fica destacado (routeIs compara pelo nome da rota) --}}
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link @if (request()->is('/')) active @endif" href="{{ url('/') }}">Início</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('produtos.*')) active @endif" href="{{ route('produtos.index') }}">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('categorias.*')) active @endif" href="{{ route('categorias.index') }}">Categorias</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('clientes.*')) active @endif" href="{{ route('clientes.index') }}">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('pedidos.*')) active @endif" href="{{ route('pedidos.index') }}">Pedidos</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('vendas.*')) active @endif" href="{{ route('vendas.create') }}">Registrar venda</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('relatorios.*')) active @endif" href="{{ route('relatorios.index') }}">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>