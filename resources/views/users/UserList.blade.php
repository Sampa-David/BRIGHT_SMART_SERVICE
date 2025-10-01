<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Utilisateurs - {{ config('app.name') }}</title>
    
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        /* Search Box */
        .search-box {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        /* User Cards */
        .user-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .user-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .user-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .user-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .user-role {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .user-body {
            padding: 1.5rem;
        }

        .user-info {
            margin-bottom: 1rem;
        }

        .user-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .user-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
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

        .btn-info {
            background: linear-gradient(135deg, var(--info-color), #2980b9);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #f39c12);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-admin {
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
            color: white;
        }

        .badge-user {
            background: linear-gradient(135deg, var(--info-color), #2980b9);
            color: white;
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

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .user-grid {
                grid-template-columns: 1fr;
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
                @if(Auth::user()->hasRole('superadmin'))
                <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                @elseif(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                @else
                <a href="{{ route('client.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                @endif
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
        <!-- Header -->
        <div class="header">
            <h1>Gestion des Utilisateurs</h1>
            <button class="btn btn-primary" onclick="showModal('userAddModal')">
                <i class="bi bi-person-plus"></i>
                Ajouter un utilisateur
            </button>
        </div>

        <!-- Search -->
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Rechercher un utilisateur..." id="searchInput">
        </div>

        <!-- Users Grid -->
        <div class="user-grid">
            @foreach($users as $user)
            <div class="user-card">
                <div class="user-header">
                    <img src="{{ asset($user->profile_picture ?? 'img/default-avatar.png') }}" 
                         alt="{{ $user->name }}" 
                         class="user-avatar">
                    <h3 class="user-name">{{ $user->name }} {{ $user->name }}</h3>
                    <span class="badge {{ $user->email === 'admin@example.com' ? 'badge-admin' : 'badge-user' }}">
                        {{ $user->email === 'admin@example.com' ? 'Administrateur' : 'Utilisateur' }}
                    </span>
                </div>
                <div class="user-body">
                    <div class="user-info">
                        <div class="user-info-item">
                            <i class="bi bi-envelope"></i>
                            {{ $user->email }}
                        </div>
                        <div class="user-info-item">
                            <i class="bi bi-telephone"></i>
                            {{ $user->phone }}
                        </div>
                        @if($user->address)
                        <div class="user-info-item">
                            <i class="bi bi-geo-alt"></i>
                            {{ $user->address }}
                        </div>
                        @endif
                    </div>
                    <div class="user-actions">
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                            Voir
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i>
                            Éditer
                        </a>
                        <button class="btn btn-danger" onclick="confirmDelete({{ $user->id }})">
                            <i class="bi bi-trash"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmer la suppression</h2>
                <button class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
            </div>
            <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
            <div class="user-actions" style="margin-top: 1.5rem;">
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Confirmer la suppression
                    </button>
                </form>
                <button class="btn btn-primary" onclick="closeModal('deleteModal')">
                    <i class="bi bi-x"></i> Annuler
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration CSRF pour les requêtes AJAX
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Recherche en temps réel
            const searchInput = document.getElementById('searchInput');
            const userCards = document.querySelectorAll('.user-card');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                
                userCards.forEach(card => {
                    const userName = card.querySelector('.user-name').textContent.toLowerCase();
                    const userEmail = card.querySelector('.user-info-item').textContent.toLowerCase();
                    
                    if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                        card.style.display = '';
                        card.style.opacity = '1';
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => card.style.display = 'none', 300);
                    }
                });
            });

            // Animation des cartes au chargement
            userCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.3s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                }, 0);
            });

            // Confirmation de déconnexion
            const logoutForm = document.querySelector('form[action="{{ route("logout") }}"]');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                        e.preventDefault();
                    }
                });
            }
        });

        // Gestion des modals
        function showModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = '';
        }

        // Confirmation de suppression
        function confirmDelete(userId) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/users/${userId}`;
            showModal('deleteModal');
        }

        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    </script>
</body>
</html>
