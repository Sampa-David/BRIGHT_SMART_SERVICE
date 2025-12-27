<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - {{ config('app.name') }}</title>
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

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 30px 20px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .sidebar-logo {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.2);
            color: white;
            padding-left: 25px;
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
            transition: margin 0.3s ease;
            overflow-x: hidden;
        }

        /* Header */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .admin-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .stat-card h3 {
            font-size: 14px;
            color: var(--gray-color);
            margin-bottom: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-card.success {
            border-left-color: var(--success-color);
        }

        .stat-card.success .value {
            color: var(--success-color);
        }

        .stat-card.warning {
            border-left-color: var(--warning-color);
        }

        .stat-card.warning .value {
            color: var(--warning-color);
        }

        .stat-card.danger {
            border-left-color: var(--danger-color);
        }

        .stat-card.danger .value {
            color: var(--danger-color);
        }

        /* Tables */
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-top: 30px;
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table thead th {
            background: var(--gray-light-color);
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--dark-color);
            border-bottom: 2px solid #ddd;
        }

        .table tbody td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:hover {
            background-color: var(--light-color);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,107,107,0.4);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background: #3db8b3;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #d43a2a;
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 12px;
        }

        /* Menu Burger */
        .menu-burger {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            z-index: 1100;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .menu-burger span {
            width: 25px;
            height: 2.5px;
            background: var(--primary-color);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .menu-burger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .menu-burger.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-burger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(46,204,113,0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background: rgba(231,74,60,0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        .alert-info {
            background: rgba(52,152,219,0.1);
            color: var(--info-color);
            border-left: 4px solid var(--info-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -280px;
                transition: left 0.3s ease;
                z-index: 1000;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .menu-burger {
                display: flex;
            }

            .admin-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .admin-header h1 {
                font-size: 24px;
            }

            .table {
                font-size: 13px;
            }

            .table thead th,
            .table tbody td {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 15px;
            }

            .admin-header h1 {
                font-size: 20px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-card .value {
                font-size: 24px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 11px;
            }

            .table {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <i class="bi bi-speedometer2"></i>
                <span>Admin</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="active"><i class="bi bi-house"></i> Tableau de bord</a></li>
                <li><a href="{{ route('admin.contacts.index') }}"><i class="bi bi-envelope"></i> Messages</a></li>
                <li><a href="{{ route('services.manage') }}"><i class="bi bi-gear"></i> Services</a></li>
                <li><a href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Utilisateurs</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <!-- Menu Burger -->
        <button class="menu-burger" id="menuBurger">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Main Content -->
        <div class="main-content">
            bottom: 0;
            width: 280px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1.5rem;
            z-index: 100;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.5) transparent;
        }

        /* Webkit scrollbar styles */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.7);
        }

        /* Firefox scrollbar styles */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.5) rgba(255, 255, 255, 0.1);
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

        .nav-item a {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.9);
            padding: 1rem 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .nav-item a:hover, .nav-item a.active {
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
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Cards */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -1rem;
        }

        .col-xl-3 {
            flex: 0 0 25%;
            max-width: 25%;
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
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            letter-spacing: 0.5px;
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
        }

        .btn i {
            margin-right: 0.5rem;
            font-size: 1.1em;
        }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,107,107,0.3);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            background: white;
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin: 1rem 0;
            max-height: 500px;
            overflow-y: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            color: var(--dark-color);
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.9rem;
        }

        .table thead {
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
        }

        .card.compact {
            max-width: 1200px;
            margin: 0 auto 2rem;
        }

        .compact .table td, 
        .compact .table th {
            padding: 0.75rem 1rem;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table th,
        .table td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-top: 1px solid var(--gray-light-color);
        }

        .table thead th {
            vertical-align: bottom;
            background-color: var(--light-color);
            border-bottom: 2px solid var(--gray-light-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: var(--gray-dark-color);
        }

        .table tbody tr:hover {
            background-color: rgba(78,205,196,0.05);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4em 0.8em;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 20px;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .bg-warning { 
            background: linear-gradient(135deg, var(--warning-color), #FFD700);
            color: #000;
        }
        .bg-success { 
            background: linear-gradient(135deg, var(--success-color), #27ae60);
            color: white;
        }
        .bg-primary { 
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
            color: white;
        }
        .bg-danger { 
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            color: white;
        }

        /* Header */
        .header {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-weight: 700;
            color: var(--dark-color);
            letter-spacing: 0.5px;
        }

        /* Utilities */
        .shadow { 
            box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important;
        }
        .mb-4 { margin-bottom: 2rem !important; }
        .ml-2 { margin-left: 0.75rem !important; }
        .mr-2 { margin-right: 0.75rem !important; }
        .py-2 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
        .d-flex { display: flex !important; }
        .align-items-center { align-items: center !important; }
        .justify-content-between { justify-content: space-between !important; }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1050;
            padding: 0.75rem;
            background: white;
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-toggle:hover {
            background: var(--light-color);
            transform: scale(1.05);
        }

        .sidebar-toggle i {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        body.sidebar-collapsed .sidebar {
            transform: translateX(-280px);
        }

        body.sidebar-collapsed .container-fluid {
            margin-left: 0;
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
        }
    </style>
</head>
<body>
    <!-- Toggle Sidebar Button -->
    <button id="sidebarToggle" class="sidebar-toggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar">
        <a href="{{route('welcome')}}" class="sidebar-brand">
            {{ config('app.name') }}
        </a>
        <hr style="border-color: rgba(255,255,255,.15)">
        @if(auth()->user()->hasRole('admin'))
        <div class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="active">
                <i class="bi bi-speedometer2"></i>
                <span>Administration</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('services.manage') }}">
                <i class="bi bi-gear"></i>
                <span>Gérer les services</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('users.index') }}">
                <i class="bi bi-people"></i>
                <span>Gestion des utilisateurs</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.contacts.index') }}">
                <i class="bi bi-envelope"></i>
                <span>Messages</span>
            </a>
        </div>
        @endif
        <div class="nav-item">
            <a href="{{ route('welcome') }}">
                <i class="bi bi-home"></i>
                <span>Voir le site</span>
            </a>
        </div>
        <hr style="border-color: rgba(255,255,255,.15)">
        <div class="nav-item">
            <a href="{{ route('profile.edit') }}">
                <i class="bi bi-person"></i>
                <span>Mon profil</span>
            </a>
        </div>
        <div class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-flex align-items-center">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </nav>

    <div class="container-fluid">
        <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <h1 style="font-size: 1.75rem; color: var(--gray-dark); margin: 0;">
                Tableau de bord Admin
            </h1>
            <div style="display: flex;justify-content:space-between">
                <a href="{{ route('services.create') }}" class="btn btn-primary mr-2">
                    <i class="bi bi-plus-lg"></i> Nouveau service
                </a>
                <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
                    <i class="bi bi-person-plus"></i> Ajouter un membre
                </button>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-envelope"></i> Messages
                    @if($stats['new_messages'] > 0)
                        <span class="badge bg-danger ml-2">{{ $stats['new_messages'] }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 0.25rem;">
                                    Demandes en attente
                                </div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                                    {{ $stats['pending_requests'] }}
                                </div>
                            </div>
                            <div>
                                <i class="bi bi-clock-history" style="font-size: 2rem; color: #dddfeb;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-left-success shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: var(--success); text-transform: uppercase; margin-bottom: 0.25rem;">
                                    Total des services
                                </div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                                    {{ $stats['total_services'] }}
                                </div>
                            </div>
                            <div>
                                <i class="bi bi-gear-fill" style="font-size: 2rem; color: #dddfeb;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: var(--info); text-transform: uppercase; margin-bottom: 0.25rem;">
                                    Nouveaux messages
                                </div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                                    {{ $stats['new_messages'] }}
                                </div>
                            </div>
                            <div>
                                <i class="bi bi-envelope-fill" style="font-size: 2rem; color: #dddfeb;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-md-6">
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: var(--info); text-transform: uppercase; margin-bottom: 0.25rem;">
                                    Total messages
                                </div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                                    {{ $stats['total_message'] }}
                                </div>
                            </div>
                            <div>
                                <i class="bi bi-envelope-fill" style="font-size: 2rem; color: #dddfeb;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-left-warning shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: var(--warning); text-transform: uppercase; margin-bottom: 0.25rem;">
                                    Clients actifs
                                </div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                                    {{ $stats['active_clients'] }}
                                </div>
                            </div>
                            <div>
                                <i class="bi bi-people-fill" style="font-size: 2rem; color: #dddfeb;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Members Section -->
        <div class="card shadow mb-4 compact">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" 
                 style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                <h6 style="font-weight: 700; margin: 0; color: white;">
                    <i class="bi bi-people-fill me-2"></i> Gestion de l'équipe
                </h6>
            </div>
            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Nom</th>
                                <th>Rôle</th>
                                <th>Département</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teamMembers as $member)
                                <tr>
                                    <td>
                                        <img src="{{ Storage::url($member->image) }}" 
                                             alt="{{ $member->name }}" 
                                             class="rounded-circle"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->role }}</td>
                                    <td data-department-id="{{ $member->department_id }}">{{ $member->department->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit-member" 
                                                data-member-id="{{ $member->id }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editTeamMemberModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('team.destroy', $member->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="card shadow mb-4 compact">
            <div class="card-header py-3 d-flex justify-content-between align-items-center" 
                 style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                <h6 style="font-weight: 700; margin: 0; color: white;">
                    <i class="bi bi-clock-history me-2"></i> Dernières demandes de service
                </h6>
                <a href="{{ route('ServiceRequest.AllRequest') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-right"></i> Voir tout
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recent_requests))
                            @foreach($recent_requests as $request)
                            <tr>
                                <td>{{ $request->user->name }}</td>
                                <td>{{ $request->service->title }}</td>
                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'completed' ? 'success' : 'primary') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('ServiceRequest.ServiceRequestShow', $request->id) }}" 
                                       class="btn btn-sm" 
                                       style="background-color: var(--info); color: white;">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-top p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Total des clients enregistrés</small>
                    <span class="badge bg-primary rounded-pill">{{ $clients->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- Users List -->
    <div class="card shadow mb-4 compact">
        <div class="card-header py-3 d-flex justify-content-between align-items-center" 
             style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
            <h6 style="font-weight: 700; margin: 0; color: white;">
                <i class="bi bi-people me-2"></i> Liste des Clients
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($clients))
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>
                                <span class="badge bg-{{ $client->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($client->status) }}
                                </span>
                            </td>
                            <td>{{ $client->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('users.show', $client->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color: var(--info); color: white;">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Team Member Modal -->
    <div class="modal fade" id="addTeamMemberModal" tabindex="-1" aria-labelledby="addTeamMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeamMemberModalLabel">Ajouter un membre de l'équipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <input type="text" class="form-control" id="role" name="role" required>
                        </div>
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Département</label>
                            <select class="form-select" id="department_id" name="department_id" required>
                                <option value="">Sélectionner un département</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biographie</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="linkedin" class="form-label">LinkedIn URL</label>
                            <input type="url" class="form-control" id="linkedin" name="linkedin">
                        </div>
                        <div class="mb-3">
                            <label for="twitter" class="form-label">Twitter URL</label>
                            <input type="url" class="form-control" id="twitter" name="twitter">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Team Member Modal -->
    <div class="modal fade" id="editTeamMemberModal" tabindex="-1" aria-labelledby="editTeamMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTeamMemberModalLabel">Modifier un membre de l'équipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTeamMemberForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Rôle</label>
                            <input type="text" class="form-control" id="edit_role" name="role" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_department_id" class="form-label">Département</label>
                            <select class="form-select" id="edit_department_id" name="department_id" required>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_bio" class="form-label">Biographie</label>
                            <textarea class="form-control" id="edit_bio" name="bio" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Photo (laisser vide pour conserver l'image actuelle)</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_linkedin" class="form-label">LinkedIn URL</label>
                            <input type="url" class="form-control" id="edit_linkedin" name="linkedin">
                        </div>
                        <div class="mb-3">
                            <label for="edit_twitter" class="form-label">Twitter URL</label>
                            <input type="url" class="form-control" id="edit_twitter" name="twitter">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const body = document.body;
            const sidebar = document.querySelector('.sidebar');
            
            // Restaurer l'état de la sidebar depuis le localStorage
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                body.classList.add('sidebar-collapsed');
            }
            
            toggleBtn.addEventListener('click', function() {
                body.classList.toggle('sidebar-collapsed');
                
                // Sauvegarder l'état dans le localStorage
                localStorage.setItem('sidebarCollapsed', body.classList.contains('sidebar-collapsed'));
            });
            
            // Fermer la sidebar en mode mobile lors du clic en dehors
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                        body.classList.add('sidebar-collapsed');
                    }
                }
            });

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            });
        });

        // Active menu item
        document.querySelectorAll('.nav-item a').forEach(link => {
            if (link.getAttribute('href') === window.location.pathname) {
                link.classList.add('active');
            }
        });

        // Menu Burger Toggle
        const menuBurger = document.getElementById('menuBurger');
        const sidebar = document.querySelector('.sidebar');

        if (menuBurger) {
            menuBurger.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                menuBurger.classList.toggle('active');
            });

            // Close menu when clicking on a link
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    menuBurger.classList.remove('active');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !menuBurger.contains(event.target)) {
                    sidebar.classList.remove('active');
                    menuBurger.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>