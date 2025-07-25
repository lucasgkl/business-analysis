<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resultados Trimestrais')</title>

    {{-- Bootstrap CSS (opcional Tailwind) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome (ícones) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Estilos adicionais --}}
    @stack('styles')
</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }
</style>

<body class="bg-light text-dark">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-chart-line"></i> Business Analysis
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('companys') }}">Empresas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Resultados</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Conteúdo Principal --}}
    <main class="py-4">
        <div class="container">
            @yield('content')
            {{ $slot ?? null }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-light text-center py-3">
        <div class="container">
            <small>&copy; {{ date('Y') }} Business Analysis. Todos os direitos reservados.</small>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Scripts adicionais --}}
    @stack('scripts')
</body>

</html>