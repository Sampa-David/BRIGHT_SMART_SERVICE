<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rôles - {{ config('app.name') }}</title>
    @include('partials.favicons')
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/bright-logo.css">
    
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
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

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

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.35rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .card {
            background: white;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
            margin-bottom: 1.5rem;
        }

        .card-header {
            padding: 1.25rem;
            border-bottom: 1px solid #e3e6f0;
            background: var(--primary);
            color: white;
            border-radius: 0.35rem 0.35rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
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

        .badge {
            display: inline-block;
            padding: 0.25em 0.75em;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 0.35rem;
        }

        .badge-admin {
            background-color: var(--primary);
            color: white;
        }

        .badge-client {
            background-color: var(--info);
            color: white;
        }

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

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
        }

        .icon {
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.5rem;
            }

            .table-responsive {
                margin: 0 -0.5rem;
            }
        }
    </style>
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
                        // Afficher le message de succès
                        const alertDiv = $('<div>')
                            .addClass('alert alert-success')
                            .text(response.message)
                            .prependTo('.container');
                        
                        // Redirection après 2 secondes
                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, response.timeout);
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        // Afficher le message d'erreur
                        const alertDiv = $('<div>')
                            .addClass('alert alert-danger')
                            .text(response.message)
                            .prependTo('.container');
                        
                        // Supprimer le message après 3 secondes
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
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="bright-logo-container" style="padding: 0;">
                        <img src="/img/logo/logo.png" alt="Bright Smart Services" class="bright-logo-header">
                    </div>
                    <h1 class="page-title">Gestion des Rôles</h1>
                </div>
                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    <i class="bi bi-shield icon"></i> Attribution des Rôles
                </h6>
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
                                <td>{{ $user->name }}</td>
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
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-shield-plus icon"></i>
                                                Assigner Admin
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('superadmin.admin.revokeAdmin', $user->id) }}" method="POST" class="d-inline role-form">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-shield-x icon"></i>
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
</body>
</html>