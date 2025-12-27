<!-- CLIENTS TABLE -->
<div class="clients-card card mb-4">
    <div class="clients-card-header card-header py-3">
        <h6 class="clients-card-header h6">
            <i class="bi bi-people"></i> Liste des Clients
        </h6>
        <span class="clients-total-badge badge">
            Total: {{ $clients->count() }}
        </span>
    </div>
    <div class="card-body p-0">
        <div class="clients-table-responsive table-responsive">
            <table class="clients-table table">
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
                            <span class="clients-status-badge {{ $client->status == 'active' ? 'active' : 'inactive' }}">
                                {{ ucfirst($client->status) }}
                            </span>
                        </td>
                        <td>{{ $client->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $client->id) }}" 
                               class="clients-action-btn btn btn-sm btn-info">
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