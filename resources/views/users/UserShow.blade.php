<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil de {{ $user->name ?? 'Client' }} - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
        <link rel="stylesheet" href="{{ asset("css/views/UserShow.blade.css") }}">
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
        <div class="profile-card">
            <div class="profile-header">
                <img src="{{ asset($user->profile_picture ?? 'img/default-avatar.png') }}" 
                     alt="{{ $user->first_name }}" 
                     class="profile-avatar">
                <h1 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h1>
                <div class="profile-role">
                    <span class="badge {{ $user->email === 'admin@example.com' ? 'badge-admin' : 'badge-user' }}">
                        <i class="bi {{ $user->email === 'admin@example.com' ? 'bi-shield-fill' : 'bi-person-fill' }}"></i>
                        {{ $user->email === 'admin@example.com' ? 'Administrateur' : 'Utilisateur' }}
                    </span>
                </div>
            </div>

            <div class="profile-body">
                <div class="info-grid">
                    <!-- Informations personnelles -->
                    <div class="info-section">
                        <h2 class="info-title">
                            <i class="bi bi-person-vcard"></i>
                            Informations personnelles
                        </h2>
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $user->email }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Téléphone</span>
                                <span class="info-value">{{ $user->phone ?? 'Non renseigné' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Adresse</span>
                                <span class="info-value">{{ $user->address ?? 'Non renseignée' }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Statistiques -->
                    <div class="info-section">
                        <h2 class="info-title">
                            <i class="bi bi-graph-up"></i>
                            Statistiques
                        </h2>
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Membre depuis</span>
                                <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Dernière connexion</span>
                                <span class="info-value">{{ $user->last_login ?? 'Jamais' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Status</span>
                                <span class="info-value">
                                    @if($user->status === 'active')
                                        <i class="bi bi-check-circle-fill" style="color: var(--success-color)"></i> Actif
                                    @else
                                        <i class="bi bi-x-circle-fill" style="color: var(--danger-color)"></i> Inactif
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Actions -->
                <div class="profile-actions">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Retour à la liste
                    </a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i>
                        Modifier
                    </a>
                    <button class="btn btn-danger" onclick="showDeleteModal()">
                        <i class="bi bi-trash"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <div class="modal-header">
                <h3 class="modal-title">Confirmer la suppression</h3>
            </div>
            <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
            <div class="modal-actions">
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                        Confirmer la suppression
                    </button>
                </form>
                <button class="btn btn-secondary" onclick="closeModal()">
                    <i class="bi bi-x"></i>
                    Annuler
                </button>
            </div>
        </div>
    </div>

    <script>
        // Animation de la carte au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const profileCard = document.querySelector('.profile-card');
            profileCard.style.opacity = '0';
            profileCard.style.transform = 'translateY(20px)';
            profileCard.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                profileCard.style.opacity = '1';
                profileCard.style.transform = 'translateY(0)';
            }, 100);
        });

        // Gestion du modal de suppression
        function showDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Fermer le modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Confirmation de déconnexion
        const logoutForm = document.querySelector('form[action="{{ route("logout") }}"]');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>
</html>

