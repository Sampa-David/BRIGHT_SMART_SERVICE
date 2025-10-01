<!-- Section Team -->
<link rel="stylesheet" href="{{ asset('css/team.css') }}">
<script src="{{ asset('js/team.js') }}" defer></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<section id="section-team">
    <div class="page-header">
        <h1 class="page-title">Gestion de l'équipe</h1>
        <div class="breadcrumb">Tableau de bord/Équipe</div>
    </div>

    <div class="action-bar mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
            <i class="bi bi-person-plus"></i> Ajouter un membre
        </button>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Membres de l'équipe</h6>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
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
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->role }}</td>
                            <td>{{ $member->department->name }}</td>
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
                                            onclick="return confirm('Êtes-vous sûr ?')">
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

    <!-- Modal d'ajout de membre -->
    <div class="modal fade" id="addTeamMemberModal" tabindex="-1" aria-labelledby="addTeamMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeamMemberModalLabel">Ajouter un membre de l'équipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTeamMemberForm" method="POST" action="{{ route('team.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Informations personnelles -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Rôle <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="role" name="role" required>
                            </div>

                            <!-- Département et Email -->
                            <div class="col-md-6 mb-3">
                                <label for="department_id" class="form-label">Département <span class="text-danger">*</span></label>
                                <select class="form-select" id="department_id" name="department_id" required>
                                    <option value="">Sélectionner un département</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <!-- Biographie -->
                            <div class="col-12 mb-3">
                                <label for="bio" class="form-label">Biographie <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
                            </div>

                            <!-- Photo -->
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">Photo de profil <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                <div class="mt-2">
                                    <img id="imagePreview" src="#" alt="Aperçu de l'image" style="max-width: 200px; display: none;">
                                </div>
                            </div>

                            <!-- Réseaux sociaux -->
                            <div class="col-md-6 mb-3">
                                <label for="linkedin" class="form-label">LinkedIn URL</label>
                                <input type="url" class="form-control" id="linkedin" name="linkedin">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="twitter" class="form-label">Twitter URL</label>
                                <input type="url" class="form-control" id="twitter" name="twitter">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter le membre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>