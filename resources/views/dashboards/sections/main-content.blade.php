    <!-- Main Content Container -->
    <main class="main-content">
        <!-- Dashboard Overview Section -->
        <section id="section-dashboard">
            <div class="header d-flex justify-content-between align-items-center">
                <h1 style="font-size: 1.75rem; color: var(--gray-dark); margin: 0;">
                    Vue d'ensemble
                </h1>
                <div class="action-buttons">
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
            @include('dashboards.partials.stats-cards')
        </section>

        <!-- Clients Section -->
        <section id="section-clients" style="display: none;">
            <div class="header">
                <h1 style="font-size: 1.75rem; color: var(--gray-dark); margin: 0;">
                    Gestion des clients
                </h1>
            </div>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Management Section -->
        <section id="section-team" style="display: none;">
            <div class="header">
                <h1 style="font-size: 1.75rem; color: var(--gray-dark); margin: 0;">
                    Gestion de l'équipe
                </h1>
            </div>
            <div class="card shadow mb-4 compact">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" 
                     style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                    <h6 style="font-weight: 700; margin: 0; color: white;">
                        <i class="bi bi-people-fill me-2"></i> Membres de l'équipe
                    </h6>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
                        <i class="bi bi-person-plus"></i> Ajouter
                    </button>
                </div>
                <div class="card-body p-0">
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
        </section>

        <!-- Service Requests Section -->
        <section id="section-requests" style="display: none;">
            <div class="header">
                <h1 style="font-size: 1.75rem; color: var(--gray-dark); margin: 0;">
                    Demandes de service
                </h1>
            </div>
            <div class="card shadow mb-4 compact">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" 
                     style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                    <h6 style="font-weight: 700; margin: 0; color: white;">
                        <i class="bi bi-clock-history me-2"></i> Dernières demandes
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>