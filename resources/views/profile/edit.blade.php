<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mon Profil - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
        <link rel="stylesheet" href="{{ asset("css/views/edit.blade.css") }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('welcome') }}" class="navbar-brand">
                <i class="bi bi-lightning-charge-fill"></i>
                {{ config('app.name') }}
            </a>
            <div class="navbar-nav">
                @if(auth()->user()->email === 'admin@example.com')
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                @else
                <a href="{{ route('client.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('status') === 'profile-updated')
        <div class="alert alert-success" id="successAlert">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Succès!</strong> Votre profil a été mis à jour avec succès.
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="profile-card">
            <div class="profile-header">
                <img src="{{ asset($user->profile_picture ?? 'img/default-avatar.png') }}" 
                     alt="Photo de profil" 
                     class="profile-avatar"
                     id="avatarPreview">
                <h1 class="profile-title">Mon Profil</h1>
                <p class="profile-subtitle">Gérez vos informations personnelles</p>
            </div>

            <div class="profile-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div style="text-align: center; margin-bottom: 2rem;">
                        <input type="file" 
                               name="profile_picture" 
                               id="profile_picture" 
                               accept="image/jpeg,image/png,image/webp,image/jpg" 
                               style="display: none;">
                        <button type="button" 
                                class="btn btn-primary" 
                                onclick="document.getElementById('profile_picture').click()">
                            <i class="bi bi-camera"></i>
                            Changer la photo
                        </button>
                        <p style="font-size: 0.85rem; color: var(--gray-color); margin-top: 0.5rem;">
                            Format: JPG, PNG, WebP | Max: 2 MB
                        </p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   class="form-input" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   placeholder="Votre nom complet">
                            @error('name')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               value="{{ old('email', $user->email) }}" 
                               required
                               placeholder="votre.email@example.com">
                        @error('email')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="form-input" 
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="+237 6XX XXX XXX">
                        @error('phone')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Localisation</label>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               class="form-input" 
                               value="{{ old('location', $user->location) }}"
                               placeholder="Ville ou localisation">
                        @error('location')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="text-align: right; margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2"></i>
                            Sauvegarder les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-body">
                <h2 style="color: var(--danger-color); margin-bottom: 1rem;">Supprimer mon compte</h2>
                <p style="margin-bottom: 1rem;">Une fois votre compte supprimé, toutes vos ressources et données seront définitivement effacées.</p>
                <button class="btn btn-danger" onclick="showDeleteModal()">
                    <i class="bi bi-trash"></i>
                    Supprimer mon compte
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <div class="modal-header">
                <h3 class="modal-title">Confirmer la suppression</h3>
            </div>
            <p style="margin-bottom: 1rem;">Cette action est irréversible. Veuillez saisir votre mot de passe pour confirmer.</p>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('delete')
                
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-input" 
                           required>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" class="btn btn-primary" onclick="closeModal()">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                        Confirmer la suppression
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Prévisualisation de l'avatar
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validation de la taille
                if (file.size > 2 * 4024 * 4024) {
                    alert('Le fichier dépasse 16 MB');
                    return;
                }

                // Validation du type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format non autorisé. Utilisez JPG, PNG ou WebP');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Afficher et masquer le message de succès
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            // Ajouter une animation d'entrée
            successAlert.style.animation = 'slideDown 0.4s ease';
            
            // Masquer après 5 secondes
            setTimeout(() => {
                successAlert.style.animation = 'slideUp 0.4s ease';
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 400);
            }, 5000);
        }

        // Gestion du modal de suppression
        function showDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Fermer le modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Animation de la carte
        document.addEventListener('DOMContentLoaded', function() {
            const profileCards = document.querySelectorAll('.profile-card');
            profileCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
        });

        // Confirmation de déconnexion
        const logoutForm = document.querySelector('form[action="{{ route("logout") }}"]');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>
</html>
