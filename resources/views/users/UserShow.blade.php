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
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 3rem 2rem;
            color: white;
            text-align: center;
            position: relative;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid white;
            margin: 0 auto 1.5rem;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .profile-body {
            padding: 2rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .info-section {
            background: var(--light-color);
            padding: 1.5rem;
            border-radius: 12px;
        }

        .info-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-list {
            list-style: none;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-color);
            min-width: 120px;
        }

        .info-value {
            color: var(--dark-color);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            gap: 0.3rem;
        }

        .badge-admin {
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
            color: white;
        }

        .badge-user {
            background: linear-gradient(135deg, var(--info-color), #2980b9);
            color: white;
        }

        /* Actions */
        .profile-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            color: white;
        }

        .btn-secondary {
            background: var(--gray-light-color);
            color: var(--dark-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-color);
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: var(--danger-color);
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        /* Activity Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--gray-light-color);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0.3rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 3px solid white;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .timeline-date {
            font-size: 0.9rem;
            color: var(--gray-color);
            margin-bottom: 0.3rem;
        }

        .timeline-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .timeline-description {
            color: var(--gray-color);
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .profile-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .modal-content {
                width: 95%;
                margin: 1rem;
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
                <a href="{{ route('contacts.manage') }}" class="nav-link">
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
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
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
