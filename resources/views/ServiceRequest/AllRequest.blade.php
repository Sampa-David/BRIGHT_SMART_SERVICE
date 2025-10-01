<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Demandes de Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69 / 15%);
        }

        .card.compact {
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 1rem 1.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            border-top: none;
            background-color: #f8f9fc;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            padding: 0.5em 0.75em;
            font-weight: 600;
        }

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            color: #858796;
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="card compact">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm me-3">
                        <i class="bi bi-arrow-left me-1"></i>Retour
                    </a>
                    <h5 class="mb-0">
                        <i class="bi bi-list-check me-2"></i>Liste des Demandes de Services
                    </h5>
                </div>
                <a href="{{ route('services.ServiceList') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Nouvelle Demande
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Service</th>
                                <th>Client</th>
                                <th>Détails</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listRequest as $request)
                                <tr>
                                    <td class="ps-3">{{ $request->id }}</td>
                                    <td>{{ $request->service->name ?? 'N/A' }}</td>
                                    <td>{{ $request->user->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($request->details, 30) }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $request->status === 'pending' ? 'warning' : 
                                            ($request->status === 'completed' ? 'success' : 
                                            ($request->status === 'cancelled' ? 'danger' : 'info')) 
                                        }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group">
                                            <a href="{{ route('ServiceRequest.ServiceRequestShow', $request->id) }}" 
                                               class="btn btn-info me-1" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('ServiceRequest.ServiceRequestEdit', $request->id) }}" 
                                               class="btn btn-primary me-1" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('ServiceRequest.ServiceRequestDestroy', $request->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')"
                                                        title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox d-block"></i>
                                            <p class="mb-0">Aucune demande de service trouvée</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($listRequest->count() > 0)
                    <div class="card-footer border-top bg-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Affichage {{ $listRequest->firstItem() ?? 0 }} à {{ $listRequest->lastItem() ?? 0 }} 
                                sur {{ $listRequest->total() }} demandes
                            </small>
                            <div>
                                {{ $listRequest->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>