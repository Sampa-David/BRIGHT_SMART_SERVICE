<!-- CLIENTS TABLE -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
        <h6 class="fw-bold m-0 text-white">
            <i class="bi bi-people me-2"></i> Liste des Clients
        </h6>
        <span class="badge bg-light text-dark">
            Total: {{ $clients->count() }}
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
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
                               class="btn btn-sm btn-info">
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