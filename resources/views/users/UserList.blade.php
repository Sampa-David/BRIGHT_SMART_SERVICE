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
    
        <link rel="stylesheet" href="{{ asset("css/views/UserList.blade.css") }}">
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
            <a href="{{ route('admin.users.index') }}" class="sidebar-nav-item active">
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
            <a href="{{ route('admin.users.index') }}" class="sidebar-nav-item active">
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
                    <tr class="@if($user->hasRole('superadmin')) superadmin-row @endif">
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
                                @if($user->hasRole('superadmin'))
                                    <button class="btn btn-info disabled-btn" onclick="showPermissionDenied()" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-warning disabled-btn" onclick="showPermissionDenied()" title="Éditer">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger disabled-btn" onclick="showPermissionDenied()" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @else
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning" title="Éditer">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-danger" onclick="confirmDelete({{ $user->id }})" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
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

    <!-- Permission Denied Modal -->
    <div class="modal" id="permissionModal">
        <div class="modal-content permission-denied-modal">
            <div class="modal-header">
                <button class="modal-close" onclick="closeModal('permissionModal')">&times;</button>
            </div>
            <div class="permission-content">
                <i class="bi bi-lock-fill permission-icon"></i>
                <h2 class="modal-title">Accès refusé</h2>
                <p>Vous n'avez pas assez de permissions pour effectuer cette action sur un Super Administrateur.</p>
            </div>
            <div class="modal-actions">
                <button class="btn btn-primary" onclick="closeModal('permissionModal')" style="width: 100%;">
                    <i class="bi bi-check"></i> Fermer
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

        // Afficher le modal d'accès refusé
        function showPermissionDenied() {
            showModal('permissionModal');
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

