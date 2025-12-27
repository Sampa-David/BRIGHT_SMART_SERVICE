@extends('layouts.admin')

@section('admin-content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Gestion de l'équipe</h6>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
            <i class="bi bi-person-plus"></i> Ajouter un membre
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
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
                            <td data-department-id="{{ $member->department_id }}">
                                {{ $member->department->name }}
                            </td>
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

<!-- Add Team Member Modal -->
<div class="modal fade" id="addTeamMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un membre de l'équipe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <input type="text" class="form-control" id="role" name="role" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Département</label>
                        <select class="form-select" id="department_id" name="department_id" required>
                            <option value="">Sélectionner un département</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Biographie</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="linkedin" class="form-label">LinkedIn URL</label>
                        <input type="url" class="form-control" id="linkedin" name="linkedin">
                    </div>
                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter URL</label>
                        <input type="url" class="form-control" id="twitter" name="twitter">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Team Member Modal -->
<div class="modal fade" id="editTeamMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un membre de l'équipe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTeamMemberForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Les mêmes champs que le formulaire d'ajout -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Rôle</label>
                        <input type="text" class="form-control" id="edit_role" name="role" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_department_id" class="form-label">Département</label>
                        <select class="form-select" id="edit_department_id" name="department_id" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_bio" class="form-label">Biographie</label>
                        <textarea class="form-control" id="edit_bio" name="bio" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Photo (laisser vide pour conserver l'image actuelle)</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="edit_linkedin" class="form-label">LinkedIn URL</label>
                        <input type="url" class="form-control" id="edit_linkedin" name="linkedin">
                    </div>
                    <div class="mb-3">
                        <label for="edit_twitter" class="form-label">Twitter URL</label>
                        <input type="url" class="form-control" id="edit_twitter" name="twitter">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du formulaire d'édition
    document.querySelectorAll('.edit-member').forEach(button => {
        button.addEventListener('click', function() {
            const memberId = this.dataset.memberId;
            const row = this.closest('tr');
            
            // Mise à jour de l'URL du formulaire
            document.getElementById('editTeamMemberForm').action = `/team/${memberId}`;
            
            // Remplissage des champs du formulaire
            document.getElementById('edit_name').value = row.cells[1].textContent.trim();
            document.getElementById('edit_role').value = row.cells[2].textContent.trim();
            document.getElementById('edit_department_id').value = row.cells[3].dataset.departmentId;
            document.getElementById('edit_email').value = row.cells[4].textContent.trim();
            
            // Récupération des données supplémentaires via AJAX
            fetch(`/team/${memberId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_bio').value = data.bio;
                    document.getElementById('edit_linkedin').value = data.linkedin || '';
                    document.getElementById('edit_twitter').value = data.twitter || '';
                });
        });
    });
});
</script>
@endsection