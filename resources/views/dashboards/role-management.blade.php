<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rôles - {{ config('app.name') }}</title>
    @include('partials.favicons')
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
        <link rel="stylesheet" href="{{ asset("css/views/role-management.blade.css") }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.role-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        const alertDiv = $('<div>')
                            .addClass('alert alert-success')
                            .html('<i class="bi bi-check-circle"></i> ' + response.message)
                            .prependTo('.container-fluid');
                        
                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, response.timeout);
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        const alertDiv = $('<div>')
                            .addClass('alert alert-danger')
                            .html('<i class="bi bi-exclamation-circle"></i> ' + response.message)
                            .prependTo('.container-fluid');
                        
                        setTimeout(function() {
                            alertDiv.fadeOut();
                        }, 3000);
                    }
                });
            });
        });
    </script>
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
                <a href="{{ route('superadmin.admins') }}" class="nav-link">
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
                <a href="{{ route('superadmin.roles') }}" class="nav-link active">
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
                        <h1 class="page-title">Gestion des Rôles</h1>
                        <p class="page-subtitle">Attribuez et gérez les rôles des utilisateurs</p>
                    </div>
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

            <!-- Table de gestion des rôles -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-title">
                        <i class="bi bi-shield-fill"></i> Attribution des Rôles
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle actuel</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->hasRole('admin'))
                                            <span class="badge badge-admin">Administrateur</span>
                                        @else
                                            <span class="badge badge-client">Client</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$user->hasRole('admin'))
                                            <form action="{{ route('superadmin.admin.makeAdmin', $user->id) }}" method="POST" class="d-inline role-form">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-shield-plus"></i>
                                                    Assigner Admin
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('superadmin.admin.revokeAdmin', $user->id) }}" method="POST" class="d-inline role-form">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-shield-x"></i>
                                                    Révoquer Admin
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
