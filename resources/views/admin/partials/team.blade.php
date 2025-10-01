<!-- TEAM TABLE -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
        <h6 class="fw-bold m-0 text-white">
            <i class="bi bi-people-fill me-2"></i> Gestion de l'équipe
        </h6>
        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
            <i class="bi bi-person-plus"></i> Ajouter
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
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
                                     style="width: 40px; height: 40px; object-fit: cover;">
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