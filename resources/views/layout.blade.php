<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo opcional -->
    <style>
        .nav-link.active {
            font-weight: bold;
            color: #fff !important;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">CertProject</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('personal_info.edit') ? 'active' : '' }}"
                            href="{{ route('personal_info.edit') }}">👤 Informações Pessoais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('educations.*') ? 'active' : '' }}"
                            href="{{ route('educations.index') }}">🎓 Formações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('certificates.*') ? 'active' : '' }}"
                            href="{{ route('certificates.index') }}">📜 Certificados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('experiences.*') ? 'active' : '' }}"
                            href="{{ route('experiences.index') }}">💼 Experiências</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}"
                            href="{{ route('projects.index') }}">🛠️ Projetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('curriculo.*') ? 'active' : '' }}"
                            href="{{ route('curriculo.index') }}">📄 Currículo</a>
                    </li>
                </ul>



                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-light btn-sm" type="submit">Logout
                                    ({{ auth()->user()->name }})
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap JS (opcional, para navbar responsiva) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<style>
    /* Limita a descrição a 3 linhas com "..." */
    .text-truncate-3 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
</style>
