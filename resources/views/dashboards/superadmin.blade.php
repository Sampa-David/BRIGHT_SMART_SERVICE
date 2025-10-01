<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - {{ config('app.name') }}</title>
    @include('partials.favicons')
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark-blue: #224abe;
            --gray: #858796;
            --gray-dark: #5a5c69;
            --light: #f8f9fc;
            --dark: #3a3b45;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fc;
            color: #858796;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .container-fluid {
            flex-grow: 1;
            padding: 1.5rem;
            margin-left: 250px;
            transition: margin 0.3s;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 250px;
            background: linear-gradient(180deg, var(--dark-blue) 10%, var(--primary) 100%);
            padding: 0;
            z-index: 100;
            transition: transform 0.3s;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-brand img {
            height: 40px;
            width: auto;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,.15);
            margin: 0 1rem;
        }

        .nav-item {
            padding: 0 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,.8);
            text-decoration: none;
            border-radius: 0.35rem;
            transition: all 0.2s;
            gap: 0.75rem;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: rgba(255,255,255,.1);
        }

        .nav-link i {
            width: 1.25rem;
            font-size: 1rem;
            text-align: center;
        }

        /* Header */
        .header {
            background: white;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.75rem;
            color: var(--gray-dark);
            margin: 0;
            font-weight: 500;
        }

        /* Cards */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -0.75rem;
        }

        .col-xl-3 {
            flex: 0 0 25%;
            max-width: 25%;
            padding: 0.75rem;
        }

        .stat-card {
            background: white;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
            border-left: 0.25rem solid var(--primary);
            margin-bottom: 1.5rem;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card.primary { border-left-color: var(--primary); }
        .stat-card.success { border-left-color: var(--success); }
        .stat-card.info { border-left-color: var(--info); }
        .stat-card.warning { border-left-color: var(--warning); }

        .stat-card-body {
            padding: 1.25rem;
        }

        .stat-card-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-card-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .stat-card.primary .stat-card-title { color: var(--primary); }
        .stat-card.success .stat-card-title { color: var(--success); }
        .stat-card.info .stat-card-title { color: var(--info); }
        .stat-card.warning .stat-card-title { color: var(--warning); }

        .stat-card-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-dark);
        }

        .stat-card-icon {
            font-size: 2rem;
            color: #dddfeb;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
            margin-bottom: 1.5rem;
        }

        .table-card-header {
            padding: 1.25rem;
            border-bottom: 1px solid #e3e6f0;
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-card-title {
            color: var(--primary);
            font-weight: 700;
            margin: 0;
            font-size: 1rem;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            color: var(--gray);
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e3e6f0;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #e3e6f0;
            background-color: var(--light);
            color: var(--gray-dark);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .table tbody tr:hover {
            background-color: var(--light);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 0.35rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--dark-blue);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 0.25em 0.75em;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 0.35rem;
        }

        .badge-success {
            background-color: var(--success);
            color: white;
        }

        .badge-warning {
            background-color: var(--warning);
            color: white;
        }

        .badge-danger {
            background-color: var(--danger);
            color: white;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .col-xl-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .col-xl-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .mobile-nav-toggle {
                display: block !important;
            }
        }

        /* Mobile Nav Toggle */
        .mobile-nav-toggle {
            display: none;
            position: fixed;
            right: 1rem;
            top: 1rem;
            z-index: 101;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 0.35rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Mobile Nav Toggle -->
    <button class="mobile-nav-toggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar">
        <a href="{{route('superadmin.dashboard')}}" class="sidebar-brand">
            <img src="{{ asset('img/logo.webp') }}" alt="Logo">
            <span>Super Admin</span>
        </a>

        <hr class="sidebar-divider">

        <div class="nav-item">
            <a href="#" class="nav-link active">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('superadmin.admins') }}" class="nav-link" target="_blank">
                <i class="bi bi-people"></i>
                <span>Administrateurs</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('superadmin.statistics') }}" class="nav-link" target="_blank">
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
            <a href="{{ route('users.index') }}" class="nav-link" target="_blank">
                <i class="bi bi-person-badge"></i>
                <span>Utilisateurs</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('superadmin.roles') }}" class="nav-link" target="_blank">
                <i class="bi bi-shield"></i>
                <span>Gestion des Rôles</span>
            </a>
        </div>

        <hr class="sidebar-divider">

        <div class="nav-item">
            <a href="{{ route('profile.edit') }}" class="nav-link" target="_blank">
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
                <h1 class="page-title">Tableau de bord Super Admin</h1>
                <a href="{{ route('superadmin.statistics') }}" class="btn btn-primary">
                    <i class="bi bi-graph-up"></i>
                    Statistiques détaillées
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert alert-success mb-4" style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 0.35rem; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3">
                <div class="stat-card primary">
                    <div class="stat-card-body">
                        <div class="stat-card-content">
                            <div>
                                <div class="stat-card-title">Administrateurs</div>
                                <div class="stat-card-value">@isset($stats['total_admins']) {{ $stats['total_admins'] }} @else 0 @endisset</div>
                            </div>
                            <i class="bi bi-people-fill stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="stat-card success">
                    <div class="stat-card-body">
                        <div class="stat-card-content">
                            <div>
                                <div class="stat-card-title">Clients</div>
                                <div class="stat-card-value">@isset($stats['total_clients']) {{ $stats['total_clients'] }} @else 0 @endisset</div>
                            </div>
                            <i class="bi bi-person-check-fill stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="stat-card info">
                    <div class="stat-card-body">
                        <div class="stat-card-content">
                            <div>
                                <div class="stat-card-title">Services</div>
                                <div class="stat-card-value">@isset($stats['total_services']) {{ $stats['total_services'] }} @else 0 @endisset</div>
                            </div>
                            <i class="bi bi-gear-fill stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="stat-card warning">
                    <div class="stat-card-body">
                        <div class="stat-card-content">
                            <div>
                                <div class="stat-card-title">Demandes en attente</div>
                                <div class="stat-card-value">@isset($stats['pending_requests']) {{ $stats['pending_requests'] }} @else 0 @endisset</div>
                            </div>
                            <i class="bi bi-clipboard-check stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Administrators Table -->
        <div class="table-card">
            <div class="table-card-header">
                <h6 class="table-card-title">Gestion des administrateurs</h6>
                <a href="{{ route('superadmin.admins') }}" class="btn btn-primary btn-sm">
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
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <span class="badge badge-{{ $admin->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('superadmin.admins.edit', $admin->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="deleteAdmin({{ $admin->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Mobile Navigation Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.mobile-nav-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            });
        });

        // Active Navigation Link
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
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

        // Stats Cards Animation
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>