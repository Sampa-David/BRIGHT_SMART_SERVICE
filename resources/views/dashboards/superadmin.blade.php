<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - {{ config('app.name') }}</title>
    @include('partials.favicons')
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
        <link rel="stylesheet" href="{{ asset("css/views/superadmin.blade.css") }}">
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
                <a href="#" class="nav-link active">
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
                        <h1 class="page-title">Tableau de bord Super Admin</h1>
                        <p class="page-subtitle">Bienvenue dans votre espace d'administration</p>
                    </div>
                    <a href="{{ route('superadmin.statistics') }}" class="btn btn-primary">
                        <i class="bi bi-graph-up"></i>
                        Statistiques détaillées
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success mb-3" style="background-color: rgba(46,204,113,0.15); color: var(--success-color); padding: 1rem; border-radius: 15px; border: 1px solid rgba(46,204,113,0.3);">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-xl-3">
                    <div class="card border-left-primary">
                        <div class="card-body">
                            <div class="card-title">Administrateurs</div>
                            <div class="card-value">@isset($stats['total_admins']) {{ $stats['total_admins'] }} @else 0 @endisset</div>
                            <small class="text-muted">Utilisateurs avec droits d'administration</small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card border-left-success">
                        <div class="card-body">
                            <div class="card-title">Clients actifs</div>
                            <div class="card-value">@isset($stats['total_clients']) {{ $stats['total_clients'] }} @else 0 @endisset</div>
                            <small class="text-muted">Utilisateurs standards</small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card border-left-info">
                        <div class="card-body">
                            <div class="card-title">Services disponibles</div>
                            <div class="card-value">@isset($stats['total_services']) {{ $stats['total_services'] }} @else 0 @endisset</div>
                            <small class="text-muted">Services du système</small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card border-left-warning">
                        <div class="card-body">
                            <div class="card-title">Demandes en attente</div>
                            <div class="card-value">@isset($stats['pending_requests']) {{ $stats['pending_requests'] }} @else 0 @endisset</div>
                            <small class="text-muted">À traiter</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats Row -->
            <div class="row">
                <div class="col-xl-3">
                    <div class="card border-left-info">
                        <div class="card-body">
                            <div class="card-title">Messages</div>
                            <div class="card-value">@isset($stats['new_messages']) {{ $stats['new_messages'] }} @else 0 @endisset</div>
                            <small class="text-muted">Non lus</small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card border-left-success">
                        <div class="card-body">
                            <div class="card-title">Utilisateurs actifs</div>
                            <div class="card-value">@isset($stats['active_users']) {{ $stats['active_users'] }} @else 0 @endisset</div>
                            <small class="text-muted">En ligne</small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card border-left-primary">
                        <div class="card-body">
                            <div class="card-title">Total demandes</div>
                            <div class="card-value">@isset($stats['total_requests']) {{ $stats['total_requests'] }} @else 0 @endisset</div>
                            <small class="text-muted">Service requests</small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card border-left-warning">
                        <div class="card-body">
                            <div class="card-title">Taux de conversion</div>
                            <div class="card-value">{{ round(isset($stats['total_requests']) && isset($stats['pending_requests']) && $stats['total_requests'] > 0 ? (($stats['total_requests'] - $stats['pending_requests']) / $stats['total_requests'] * 100) : 0) }}%</div>
                            <small class="text-muted">Demandes traitées</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Administrators Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-title">
                        <i class="bi bi-people"></i> Gestion des administrateurs
                    </h5>
                    <a href="{{ route('superadmin.admins') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-eye"></i>
                        Voir tout
                    </a>
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
                            @foreach($admins as $admin)
                            <tr>
                                <td>
                                    <strong>{{ $admin->name }}</strong>
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-{{ $admin->status === 'active' ? 'success' : 'danger' }}">
                                        {{ $admin->status === 'active' ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('superadmin.admins.edit', $admin->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Éditer
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteAdmin({{ $admin->id }})">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
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
        // Active Navigation Link
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

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

        // Delete Admin Confirmation
        function deleteAdmin(adminId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/superadmin/admins/${adminId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
