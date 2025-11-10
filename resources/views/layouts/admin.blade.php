<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Celke</title>

    {{-- Verifica se o build do Vite existe --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @else
        {{-- Fallback: usa Bootstrap via CDN se o Vite ainda não estiver compilado --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    {{-- Ícones do Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Seu CSS personalizado --}}
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>

    <div class="d-flex flex-nowrap">
        {{-- Sidebar principal --}}
        <div class="flex-shrink-0 p-3 bg-petroleo border-end" style="width: 280px; min-height: 100vh;">
            <a href="{{ url('/') }}" class="d-flex align-items-center pb-3 mb-3 text-white text-decoration-none border-bottom">
                <svg class="bi pe-none me-2" width="30" height="24" aria-hidden="true">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-5 fw-semibold">Painel Admin</span>
            </a>

            <ul class="list-unstyled ps-0">
                {{-- Menu Home (agora fechado por padrão) --}}
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        <i class="bi bi-house-door me-2"></i> Home
                    </button>
                    <div class="collapse" id="home-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{ route('user.index') }}" class="d-inline-flex text-decoration-none rounded">Usuários</a></li>
                            <li><a href="#" class="d-inline-flex text-decoration-none rounded">Dashboard</a></li>
                            <li><a href="#" class="d-inline-flex text-decoration-none rounded">Configurações</a></li>
                        </ul>
                    </div>
                </li>

                {{-- Menu Pedidos --}}
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                        <i class="bi bi-table me-2"></i> Pedidos
                    </button>
                    <div class="collapse" id="orders-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" class="d-inline-flex text-decoration-none rounded">Novos</a></li>
                            <li><a href="#" class="d-inline-flex text-decoration-none rounded">Finalizados</a></li>
                        </ul>
                    </div>
                </li>

                {{-- Menu Produtos --}}
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#products-collapse" aria-expanded="false">
                        <i class="bi bi-grid me-2"></i> Produtos
                    </button>
                    <div class="collapse" id="products-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" class="d-inline-flex text-decoration-none rounded">Cadastrar</a></li>
                            <li><a href="#" class="d-inline-flex text-decoration-none rounded">Listar</a></li>
                        </ul>
                    </div>
                </li>

                <li class="border-top my-3"></li>

                {{-- Menu Clientes --}}
                <li class="mb-1">
                    <a href="#" class="d-inline-flex text-decoration-none align-items-center">
                        <i class="bi bi-people me-2"></i> Clientes
                    </a>
                </li>

                {{-- Dropdown Usuário --}}
                <li class="mt-3 border-top pt-3">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="Foto do usuário" width="32" height="32" class="rounded-circle me-2">
                            <strong>Admin</strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#">Sair</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        {{-- Conteúdo principal --}}
        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
