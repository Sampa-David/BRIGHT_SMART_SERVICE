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
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -1rem;
        }

        .col-xl-3, .col-md-6 {
            padding: 1rem;
        }

        .col-xl-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 1rem;
        }

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

        .card.border-left-primary { 
            border-left: 4px solid var(--primary-color);
            background: linear-gradient(to right, rgba(255,107,107,0.05), white);
        }

        .card.border-left-success { 
            border-left: 4px solid var(--success-color);
            background: linear-gradient(to right, rgba(46,204,113,0.05), white);
        }

        .card.border-left-info { 
            border-left: 4px solid var(--secondary-color);
            background: linear-gradient(to right, rgba(78,205,196,0.05), white);
        }

        .card.border-left-warning { 
            border-left: 4px solid var(--warning-color);
            background: linear-gradient(to right, rgba(241,196,15,0.05), white);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            margin-bottom: 1rem;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray-color);
        }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .card-icon {
            font-size: 3rem;
            opacity: 0.2;
            text-align: right;
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

        .btn-success {
            color: white;
            background: linear-gradient(135deg, var(--success-color), #27ae60);
        }

        .btn-warning {
            color: white;
            background: linear-gradient(135deg, var(--warning-color), #f39c12);
        }

        .btn-danger {
            color: white;
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            background: white;
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        /* Tables */
        .table-responsive {
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin: 1rem 0;
            max-height: 500px;
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

        /* Utilities */
        .mt-3 {
            margin-top: 1.5rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: var(--gray-color);
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

            .col-xl-3, .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0.75rem;
            }

            .col-12 {
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0.75rem;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .page-subtitle {
                font-size: 0.8rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-value {
                font-size: 1.5rem;
            }

            .table th, .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }

            .table th:last-child, .table td:last-child {
                min-width: 130px;
            }

            .table-responsive {
                max-height: 400px;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }

            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .container-fluid {
                padding: 1rem 0.75rem;
            }

            .header {
                padding: 0.75rem;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .col-xl-3, .col-md-6 {
                padding: 0.5rem;
            }

            .card-value {
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

            .nav-item a {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.65rem;
            }

            .table th, .table td {
                padding: 0.5rem 0.25rem;
                font-size: 0.65rem;
            }

            .table th:last-child, .table td:last-child {
                min-width: 100px;
                padding: 0.5rem 0.5rem;
            }

            .btn i {
                margin-right: 0.25rem;
                font-size: 0.85em;
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