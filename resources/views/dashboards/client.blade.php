<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mon tableau de bord - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
        <link rel="stylesheet" href="{{ asset("css/views/client.blade.css") }}">
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
                <a href="{{ route('services.ServiceList') }}" class="nav-link">
                    <i class="bi bi-grid"></i> Services
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="bi bi-person"></i> Mon profil
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
        <!-- Flash error message -->
        @if(session('error'))
        <div class="alert alert-danger mb-4" style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 0.35rem; border: 1px solid #f5c6cb; max-width: 1200px; margin: 0 auto;">
            {{ session('error') }}
        </div>
        @endif
<div class="container">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3">Mon tableau de bord</h1>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <h5 class="card-title">Services actifs</h5>
                    <p class="card-text display-6">{{ $data['active_services'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h5 class="card-title">Services complétés</h5>
                    <p class="card-text display-6">{{ $data['completed_services'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-info h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-info mb-2">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <h5 class="card-title">Prochaine échéance</h5>
                    <p class="card-text">
                        @if(isset($data['next_deadline']))
                            {{ $data['next_deadline']->format('d/m/Y') }}
                        @else
                            Aucune échéance
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mes dernières demandes -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Mes dernières demandes</h6>
            <a href="{{ route('services.ServiceList') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Nouvelle demande
            </a>
        </div>
        <div class="card-body">
            @if($data['my_requests']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Date de demande</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['my_requests'] as $request)
                            <tr>
                                <td>{{ $request->service->title }}</td>
                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'completed' ? 'success' : 'primary') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('ServiceRequest.ServiceRequestShow', $request->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Détails
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-clipboard-x display-1 text-muted"></i>
                    </div>
                    <h5>Aucune demande de service</h5>
                    <p class="text-muted">Vous n'avez pas encore fait de demande de service.</p>
                    <a href="{{ route('services.ServiceList') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Faire une demande
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Conseils et astuces -->
    <div class="card bg-light border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title">
                <i class="bi bi-lightbulb text-warning"></i> Le saviez-vous ?
            </h5>
            <p class="card-text">
                Vous pouvez suivre l'état de vos demandes de service en temps réel et communiquer directement avec nos équipes via votre tableau de bord.
            </p>
            <a href="#" class="btn btn-link text-primary p-0">En savoir plus <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

    <script>
        // Configuration CSRF pour les requêtes AJAX
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter le token CSRF à toutes les requêtes AJAX
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Gestionnaire pour les boutons de déconnexion
            document.querySelectorAll('form[action="{{ route("logout") }}"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                        e.preventDefault();
                    }
                });
            });

            // Animation des cartes au survol
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Gestion des transitions de couleur pour les badges
            document.querySelectorAll('.badge').forEach(badge => {
                badge.style.transition = 'all 0.3s ease';
            });
        });
    </script>
</body>
</html>
