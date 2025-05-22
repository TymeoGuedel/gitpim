<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Gîte Pim')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap + icônes --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
        }
        .sidebar a {
            color: #ced4da;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }
        .main-content {
            margin-left: 220px;
        }
    </style>
</head>
<body>

<div class="d-flex">
    {{-- SIDEBAR --}}
    <nav class="sidebar position-fixed w-220">
        <h5 class="text-center py-3 border-bottom">Gîte Pim</h5>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="{{ route('admin.reservations_chambres.index') }}" class="{{ request()->is('admin/reservations_chambres*') ? 'active' : '' }}"><i class="bi bi-bed"></i> Chambres</a>
        <a href="{{ route('admin.stats.globales') }}"><i class="bi bi-bar-chart-line"></i> Statistiques</a>

        <a href="#"><i class="bi bi-calendar3-week"></i> Toutes réservations</a>
    </nav>

    <div class="main-content flex-grow-1">
        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand px-4">
            <div class="container-fluid justify-content-between">
                <span class="navbar-brand">@yield('header', 'Admin')</span>
                <div>
                    <a href="/" class="btn btn-outline-secondary btn-sm">Voir le site</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-danger">Déconnexion</button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- CONTENU PRINCIPAL --}}
        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
