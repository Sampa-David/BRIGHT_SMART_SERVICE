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
    
    <style>
        :root {
            --primary-color: #FF6B6B;
            --secondary-color: #4ECDC4;
            --dark-color: #2C3E50;
            --light-color: #F7F9FC;
            --success-color: #2ECC71;
            --warning-color: #F1C40F;
            --danger-color: #E74C3C;
            --info-color: #3498DB;
            --gray-color: #95A5A6;
            --gray-light-color: #ECF0F1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        .container-fluid {
            flex-grow: 1;
            padding: 2rem;
            margin-left: 280px;
            transition: margin 0.3s ease;
            width: 100%;
            overflow-x: hidden;
        }

        /* Menu Toggle Button */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 101;
            background: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            align-items: center;
            justify-content: center;
        }

        .menu-toggle:hover {
            background: var(--light-color);
            transform: scale(1.05);
        }

        .menu-toggle.active {
            left: 300px;
            color: white;
            background: var(--primary-color);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 280px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1.5rem;
            z-index: 100;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
            overflow-y: auto;
            transition: left 0.3s ease;
        }

        .sidebar-brand {
            color: white;
            font-size: 1.4rem;
            text-decoration: none;
            padding: 1.5rem 1rem;
            display: flex;
            align-items: center;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }

        .sidebar-brand img {
            height: 40px;
            width: auto;
            margin-right: 0.5rem;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,.15);
            margin: 1rem 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.9);
            padding: 1rem 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 10px;
            font-weight: 500;
        }

        .nav-item a:hover, 
        .nav-item a.active {
            color: white;
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
        }

        .nav-item i {
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        /* Header */
        .header {
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 15px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2rem;
            color: var(--dark-color);
            margin: 0;
            font-weight: 700;
        }

        .page-subtitle {
            color: var(--gray-color);
            margin: 0;
            font-size: 0.9rem;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            padding: 1.5rem;
            background-color: white;
            border-bottom: 1px solid var(--gray-light-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-title {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
            font-size: 1.1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
            line-height: 1.5;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            border: none;
        }

        .btn i {
            margin-right: 0.5rem;
            font-size: 1.1em;
        }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,107,107,0.3);
        }

        .btn-warning {
            color: white;
            background: linear-gradient(135deg, var(--warning-color), #f39c12);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(241,196,15,0.3);
        }

        .btn-danger {
            color: white;
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231,76,60,0.3);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        /* Actions Column */
        td:last-child {
            white-space: normal;
            word-wrap: break-word;
        }

        td:last-child .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        td:last-child form {
            display: inline-block;
        }

        /* Tables */
        .table-responsive {
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin: 1rem 0;
            max-height: 600px;
            overflow-y: auto;
            width: 100%;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            color: var(--dark-color);
            border-collapse: collapse;
            min-width: 100%;
        }

        .table th {
            background-color: var(--light-color);
            color: var(--dark-color);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            padding: 1rem;
            border-bottom: 2px solid var(--gray-light-color);
            position: sticky;
            top: 0;
        }

        .table th:last-child {
            min-width: 140px;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-light-color);
        }

        .table td:last-child {
            white-space: normal;
            word-wrap: break-word;
        }

        .table tbody tr:hover {
            background-color: var(--light-color);
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 20px;
        }

        .badge-success {
            background-color: rgba(46,204,113,0.15);
            color: var(--success-color);
        }

        .badge-warning {
            background-color: rgba(241,196,15,0.15);
            color: #d68910;
        }

        .badge-danger {
            background-color: rgba(231,76,60,0.15);
            color: var(--danger-color);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 15px;
            border: none;
        }

        .alert-success {
            background-color: rgba(46,204,113,0.15);
            color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(231,76,60,0.15);
            color: var(--danger-color);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid var(--gray-light-color);
            border-radius: 8px;
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .pagination .active span {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Utilities */
        .text-center {
            text-align: center;
        }

        .text-muted {
            color: var(--gray-color);
        }

        .py-4 {
            padding: 1.5rem 0;
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .container-fluid {
                margin-left: 0;
                padding: 1.5rem 1rem;
                padding-top: 5rem;
                width: 100%;
            }

            .menu-toggle {
                display: flex;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                width: 280px;
                height: 100vh;
                z-index: 99;
                box-shadow: 2px 0 15px rgba(0,0,0,0.2);
            }

            .sidebar.active {
                left: 0;
            }

            .sidebar.active ~ .menu-toggle {
                left: 300px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .table th, .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }

            td:last-child .btn {
                min-height: 32px;
                display: flex;
                align-items: center;
                margin: 0.25rem 0.25rem 0.25rem 0;
            }

            td:last-child {
                min-width: 150px;
            }
        }

        @media (max-width: 480px) {
            .container-fluid {
                padding: 1rem 0.75rem;
            }

            .table th, .table td {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }

            .btn-sm {
                padding: 0.35rem 0.6rem;
                font-size: 0.7rem;
            }

            .btn i {
                margin-right: 0.25rem;
                font-size: 0.9em;
            }

            td:last-child {
                min-width: 120px;
            }

            td:last-child .btn {
                padding: 0.4rem 0.6rem;
                white-space: nowrap;
                flex-wrap: wrap;
            }

            td:last-child form {
                margin-top: 0.25rem;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .sidebar {
                width: 250px;
                left: -250px;
            }

            .sidebar-brand {
                padding: 1rem 0.75rem;
                font-size: 1rem;
            }

            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.75rem;
            }

            .table-responsive {
                max-height: 400px;
            }
        }
    </style>
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
                <a href="{{ route('users.index') }}" class="nav-link">
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
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
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