<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Administrateurs - {{ config('app.name') }}</title>
    @include('partials.favicons')
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
        <link rel="stylesheet" href="{{ asset("css/views/index.blade.css") }}">
</head>
<body>
    <div class="wrapper">
        <!-- Menu Toggle Button -->
        <button class="menu-toggle" id="menuToggle" title="Menu">
            <i class="bi bi-list"></i>
        </button>

        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <a href="{{route('superadmin.dashboard')}}" class="sidebar-brand">
                <img src="{{ asset('img/logo.webp') }}" alt="Logo">
                <span>Super Admin</span>
            </a>

            <div class="sidebar-divider"></div>

            <div class="nav-item">
                <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Tableau de bord</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('superadmin.admins') }}" class="nav-link active">
                    <i class="bi bi-people"></i>
                    <span>Administrateurs</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('superadmin.statistics') }}" class="nav-link">
                    <i class="bi bi-graph-up"></i>
                    <span>Statistiques</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('services.manage') }}" class="nav-link">
                    <i class="bi bi-gear"></i>
                    <span>Services</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="bi bi-person-badge"></i>
                    <span>Utilisateurs</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('superadmin.roles') }}" class="nav-link">
                    <i class="bi bi-shield"></i>
                    <span>Gestion des Rôles</span>
                </a>
            </div>

            <div class="sidebar-divider"></div>

            <div class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="bi bi-person"></i>
                    <span>Mon profil</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </nav>

        <div class="container-fluid">
            <!-- Header -->
            <div class="header">
                <div class="header-content">
                    <div>
                        <h1 class="page-title">Gestion des Administrateurs</h1>
                        <p class="page-subtitle">Gérez tous les administrateurs du système</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Ajouter un administrateur
                    </a>
                </div>
            </div>

            <!-- Messages de notification -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Table des administrateurs -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-title">
                        <i class="bi bi-people-fill"></i> Liste des administrateurs
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date de création</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td>
                                        <strong>{{ $admin->name }}</strong>
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $admin->status === 'active' ? 'success' : 'warning' }}">
                                            {{ $admin->status === 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.admins.edit', $admin->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Éditer
                                        </a>
                                        <form action="{{ route('superadmin.admins.destroy', $admin->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?')">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-inbox"></i> Aucun administrateur trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($admins->hasPages())
                <div class="card">
                    <div class="table-responsive" style="margin: 0; max-height: none; box-shadow: none;">
                        <div style="padding: 1.5rem; text-align: center;">
                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Menu Toggle Functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        // Close sidebar when clicking on a nav link
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    menuToggle.classList.remove('active');
                }
            });
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickInsideToggle = menuToggle.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickInsideToggle && window.innerWidth <= 768) {
                sidebar.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    </script>
</body>
</html>
