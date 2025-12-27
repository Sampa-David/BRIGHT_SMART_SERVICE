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
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Admin Dashboard Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
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
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </aside>

        <!-- Menu Burger Button (Mobile) - Navigation -->
        <button class="menu-burger" id="menuBurger" aria-label="Toggle navigation menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Menu Burger Button (Mobile) - Actions -->
        <button class="menu-burger menu-burger-actions" id="menuBurgerActions" aria-label="Toggle actions menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid">
        <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <h1 style="font-size: 1.75rem; color: var(--gray-dark); margin: 0;">
                Tableau de bord Administrateur
            </h1>
            <!-- Actions Sidebar (In Header for Desktop) -->
            <aside class="sidebar sidebar-actions" id="sidebarActions">
                <div class="actions-list">
                    <a href="{{ route('services.create') }}" class="action-item">
                        <i class="bi bi-plus-lg"></i>
                        <span>Nouveau service</span>
                    </a>
                    <button type="button" class="action-item" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
                        <i class="bi bi-envelope"></i>
                        <span>Envoyer un message</span>
                    </button>
                    <a href="{{ route('admin.contacts.index') }}" class="action-item">
                        <i class="bi bi-envelope"></i>
                        <span>Messages
                            @if($stats['new_messages'] > 0)
                                <span class="badge bg-danger ms-2">{{ $stats['new_messages'] }}</span>
                            @endif
                        </span>
                    </a>
                </div>
            </aside>
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
    </div>

    <!-- Modal: Send Message -->
    <div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                    <h5 class="modal-title" id="sendMessageModalLabel">
                        <i class="bi bi-envelope-plus me-2"></i> Envoyer un message
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.contacts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient_email" class="form-label">Email du destinataire</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="recipient_email" name="email" required placeholder="destinataire@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="recipient_name" class="form-label">Nom du destinataire</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="recipient_name" name="name" required placeholder="Nom complet">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message_subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="message_subject" name="subject" required placeholder="Sujet du message">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message_body" class="form-label">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message_body" name="message" rows="6" required 
                                      placeholder="Écrivez votre message ici..."></textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="send_email" name="send_email" value="1" checked>
                            <label class="form-check-label" for="send_email">
                                Envoyer un email au destinataire
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i> Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Menu Burger Toggle for Mobile - Navigation Sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const menuBurger = document.getElementById('menuBurger');
            const sidebar = document.getElementById('sidebar');

            if (menuBurger && sidebar) {
                menuBurger.addEventListener('click', function(e) {
                    e.stopPropagation();
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

            // Active menu item
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                if (link.getAttribute('href') === window.location.pathname) {
                    link.classList.add('active');
                }
            });
        });

        // Menu Burger Toggle for Mobile - Actions Sidebar (Right)
        document.addEventListener('DOMContentLoaded', function() {
            const menuBurgerActions = document.getElementById('menuBurgerActions');
            const sidebarActions = document.getElementById('sidebarActions');

            if (menuBurgerActions && sidebarActions) {
                menuBurgerActions.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebarActions.classList.toggle('active');
                    menuBurgerActions.classList.toggle('active');
                });

                // Close menu when clicking on a link
                document.querySelectorAll('.actions-list a, .actions-list button').forEach(item => {
                    item.addEventListener('click', function() {
                        sidebarActions.classList.remove('active');
                        menuBurgerActions.classList.remove('active');
                    });
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!sidebarActions.contains(event.target) && !menuBurgerActions.contains(event.target)) {
                        sidebarActions.classList.remove('active');
                        menuBurgerActions.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>
</html>