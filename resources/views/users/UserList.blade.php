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
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 2.5rem;
            text-decoration: none;
            color: white;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar-nav-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }

        .sidebar-nav-item.active {
            background: rgba(255,255,255,0.3);
            border-left: 3px solid white;
            padding-left: 0.7rem;
        }

        .sidebar-nav-item i {
            font-size: 1.2rem;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.2);
            margin: 1rem 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            width: 100%;
            overflow-x: hidden;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .header-subtitle {
            color: var(--gray-color);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        /* Search Box */
        .search-box {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.5rem 1rem 2.5rem;
            border: none;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        th {
            padding: 1.25rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-light-color);
        }

        th:last-child {
            min-width: 140px;
            text-align: center;
        }

        td:last-child {
            min-width: 140px;
            white-space: normal;
            word-wrap: break-word;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: var(--light-color);
            transform: scale(1.01);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Avatar */
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gray-light-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-details h6 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .user-details p {
            margin: 0.25rem 0 0;
            font-size: 0.85rem;
            color: var(--gray-color);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            background: var(--gray-light-color);
            color: var(--dark-color);
        }

        .badge-admin {
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
            color: white;
        }

        .badge-client {
            background: linear-gradient(135deg, var(--info-color), #2980b9);
            color: white;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
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

        .btn i {
            font-size: 0.9rem;
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .actions .btn {
            min-width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.4rem 0.6rem;
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
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 230px;
                padding: 1.5rem 1rem;
            }

            .main-content {
                margin-left: 230px;
                padding: 1.5rem;
            }

            th, td {
                padding: 1rem 0.75rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                height: 100vh;
                z-index: 999;
                transition: left 0.3s ease;
                width: 280px;
                box-shadow: 2px 0 15px rgba(0,0,0,0.2);
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem 1rem;
                width: 100%;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .header-subtitle {
                font-size: 0.8rem;
            }

            th, td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }

            th:last-child, td:last-child {
                min-width: 140px;
            }

            .avatar {
                width: 35px;
                height: 35px;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .actions .btn {
                min-width: auto;
                height: auto;
                padding: 0.35rem 0.5rem;
                margin: 0.2rem;
            }

            .user-details h6 {
                font-size: 0.85rem;
            }

            .user-details p {
                font-size: 0.75rem;
            }

            .modal-content {
                width: 95%;
            }

            .actions {
                flex-wrap: wrap;
                gap: 0.25rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 1rem 0.75rem;
            }

            .header {
                padding: 0.75rem 0;
            }

            .header h1 {
                font-size: 1.25rem;
            }

            .sidebar {
                width: 250px;
                left: -250px;
            }

            .sidebar-brand {
                font-size: 1rem;
            }

            .sidebar-nav-item {
                padding: 0.6rem 0.8rem;
                font-size: 0.85rem;
            }

            th, td {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }

            th:last-child, td:last-child {
                min-width: 120px;
                padding: 0.5rem 0.5rem;
            }

            .avatar {
                width: 30px;
                height: 30px;
            }

            .btn {
                padding: 0.3rem 0.6rem;
                font-size: 0.65rem;
            }

            .actions {
                flex-direction: row;
                gap: 0.2rem;
            }

            .actions .btn {
                min-width: 28px;
                height: 28px;
                padding: 0.25rem 0.4rem;
                border-radius: 6px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .actions .btn i {
                font-size: 0.75rem;
                margin: 0;
            }

            .user-info {
                gap: 0.5rem;
            }

            .user-details h6 {
                font-size: 0.75rem;
            }

            .user-details p {
                display: none;
            }

            .search-input {
                padding: 0.75rem 1.5rem 0.75rem 2rem;
                font-size: 0.9rem;
            }

            .table-container {
                border-radius: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('welcome') }}" class="sidebar-logo">
            <i class="bi bi-lightning-charge-fill"></i>
            <span>{{ config('app.name') }}</span>
        </a>

        <nav class="sidebar-nav">
            @if(Auth::user()->hasRole('superadmin'))
            <a href="{{ route('superadmin.dashboard') }}" class="sidebar-nav-item">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('users.index') }}" class="sidebar-nav-item active">
                <i class="bi bi-people"></i>
                <span>Utilisateurs</span>
            </a>
            <a href="{{ route('superadmin.roles') }}" class="sidebar-nav-item">
                <i class="bi bi-shield-check"></i>
                <span>Rôles</span>
            </a>
            <a href="{{ route('services.manage') }}" class="sidebar-nav-item">
                <i class="bi bi-gear"></i>
                <span>Services</span>
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="sidebar-nav-item">
                <i class="bi bi-envelope"></i>
                <span>Messages</span>
            </a>
            @elseif(Auth::user()->hasRole('admin'))
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('users.index') }}" class="sidebar-nav-item active">
                <i class="bi bi-people"></i>
                <span>Utilisateurs</span>
            </a>
            <a href="{{ route('services.manage') }}" class="sidebar-nav-item">
                <i class="bi bi-gear"></i>
                <span>Services</span>
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="sidebar-nav-item">
                <i class="bi bi-envelope"></i>
                <span>Messages</span>
            </a>
            @else
            <a href="{{ route('client.dashboard') }}" class="sidebar-nav-item">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('users.index') }}" class="sidebar-nav-item active">
                <i class="bi bi-people"></i>
                <span>Mon compte</span>
            </a>
            @endif
        </nav>

        <div class="sidebar-divider"></div>

        <nav class="sidebar-nav">
            <a href="{{ route('profile.edit') }}" class="sidebar-nav-item">
                <i class="bi bi-person"></i>
                <span>Profil</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="sidebar-nav-item" style="width: 100%; background: none; border: none; padding: 0.75rem 1rem; justify-content: flex-start;">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>Gestion des Utilisateurs</h1>
                <p class="header-subtitle">Gérez et consultez la liste de tous les utilisateurs</p>
            </div>
            <button class="btn btn-primary" onclick="showModal('userAddModal')">
                <i class="bi bi-person-plus"></i>
                Ajouter un utilisateur
            </button>
        </div>

        <!-- Search -->
        <div class="search-box">
            <i class="bi bi-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Rechercher un utilisateur..." id="searchInput">
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <img src="{{ asset($user->profile_picture ?? 'img/default-avatar.png') }}" 
                                     alt="{{ $user->name }}" 
                                     class="avatar">
                                <div class="user-details">
                                    <h6>{{ $user->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            @if($user->hasRole('superadmin'))
                                <span class="badge badge-admin">
                                    <i class="bi bi-shield-check"></i>
                                    Superadmin
                                </span>
                            @elseif($user->hasRole('admin'))
                                <span class="badge badge-admin">
                                    <i class="bi bi-shield"></i>
                                    Administrateur
                                </span>
                            @else
                                <span class="badge badge-client">
                                    <i class="bi bi-person"></i>
                                    Client
                                </span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning" title="Éditer">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-danger" onclick="confirmDelete({{ $user->id }})" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem;">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: var(--gray-color);"></i>
                            <p style="margin-top: 1rem; color: var(--gray-color);">Aucun utilisateur trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
            <div class="modal-actions">
                <form id="deleteForm" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                        <i class="bi bi-trash"></i> Confirmer la suppression
                    </button>
                </form>
                <button class="btn btn-primary" onclick="closeModal('deleteModal')" style="flex: 1;">
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
            const tableBody = document.querySelector('tbody');
            const rows = tableBody.querySelectorAll('tr');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                let visibleCount = 0;
                
                rows.forEach(row => {
                    if (row.querySelector('td[colspan]')) return; // Skip empty message row
                    
                    const text = row.textContent.toLowerCase();
                    
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show empty message if no results
                if (visibleCount === 0 && searchTerm !== '') {
                    let emptyRow = tableBody.querySelector('tr[data-empty]');
                    if (!emptyRow) {
                        emptyRow = document.createElement('tr');
                        emptyRow.setAttribute('data-empty', 'true');
                        emptyRow.innerHTML = '<td colspan="6" style="text-align: center; padding: 2rem;"><i class="bi bi-inbox" style="font-size: 2rem; color: var(--gray-color);"></i><p style="margin-top: 1rem; color: var(--gray-color);">Aucun résultat trouvé</p></td>';
                        tableBody.appendChild(emptyRow);
                    }
                    emptyRow.style.display = '';
                } else {
                    let emptyRow = tableBody.querySelector('tr[data-empty]');
                    if (emptyRow) emptyRow.style.display = 'none';
                }
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
