<!-- Section Services -->
<section id="section-services" style="display: none;">
    <div class="page-header">
        <h1 class="page-title">Gestion des Services</h1>
        <div class="breadcrumb">Tableau de bord/Services</div>
    </div>

    <div class="action-bar mb-4">
        <a href="{{ route('services.manage') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouveau service
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Liste des services</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>{{ Str::limit($service->description, 100) }}</td>
                            <td>
                                <span class="badge bg-{{ $service->is_active ? 'success' : 'warning' }}">
                                    {{ $service->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('services.ServiceEdit', $service->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('services.ServiceDestroy', $service->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
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