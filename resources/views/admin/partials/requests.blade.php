<!-- REQUESTS TABLE -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
        <h6 class="fw-bold m-0 text-white">
            <i class="bi bi-clock-history me-2"></i> Dernières demandes de service
        </h6>
        <a href="{{ route('ServiceRequest.AllRequest') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-right"></i> Voir tout
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
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