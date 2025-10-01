<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Messages de contact - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
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
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header */
        .header {
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background: linear-gradient(to right, var(--success-color), #27ae60);
            color: white;
            box-shadow: 0 4px 15px rgba(46,204,113,0.2);
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: var(--light-color);
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: var(--dark-color);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid var(--gray-light-color);
            font-size: 0.9rem;
        }

        .table tr:hover td {
            background: rgba(78,205,196,0.05);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5em 1em;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-email {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .badge-phone {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }

        .badge-new {
            background: linear-gradient(135deg, #f1c40f, #f39c12);
            color: var(--dark-color);
        }

        .badge-answered {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }

        /* Actions */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            gap: 0.5rem;
        }

        .btn-info {
            background: var(--info-color);
            color: white;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(52,152,219,0.3);
        }

        /* Pagination */
        .pagination-container {
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top: 1px solid var(--gray-light-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .navbar-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .navbar-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .table-container {
                overflow-x: auto;
            }

            .table th,
            .table td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('welcome') }}" class="navbar-brand">
                <i class="bi bi-lightning-charge-fill"></i>
                {{ config('app.name') }}
            </a>
            <div class="navbar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('services.manage') }}" class="nav-link">
                    <i class="bi bi-gear"></i> Services
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="nav-link">
                    <i class="bi bi-envelope"></i> Messages
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="bi bi-person"></i> Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="header">
            <h1>Messages de contact</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Méthode</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>
                            <span class="badge badge-{{ $contact->contact_method === 'email' ? 'email' : 'phone' }}">
                                <i class="bi bi-{{ $contact->contact_method === 'email' ? 'envelope' : 'telephone' }} me-1"></i>
                                {{ ucfirst($contact->contact_method) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $contact->status === 'new' ? 'new' : 'answered' }}">
                                <i class="bi bi-{{ $contact->status === 'new' ? 'star' : 'check2-circle' }} me-1"></i>
                                {{ $contact->status === 'new' ? 'Nouveau' : 'Répondu' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                                Voir
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration CSRF pour les requêtes AJAX
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Auto-dismiss des alertes après 5 secondes
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });

            // Animation des lignes du tableau au survol
            let tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s ease';
                    this.style.transform = 'translateX(5px)';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Animation des badges
            let badges = document.querySelectorAll('.badge');
            badges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                });
                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Confirmation de déconnexion
            let logoutForm = document.querySelector('form[action="{{ route("logout") }}"]');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>
