<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modifier l'utilisateur - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #FF6B6B;
            --secondary-color: #4ECDC4;
            --dark-color: #2C3E50;
            --light-color: #F7F9FC;
            --success-color: #2ECC71;
            --warning-color: #F1C40F;
            --danger-color: #E74C3C;
            --info-color: #3498DB;
            --gray-color: #95A5A6;
            --gray-light-color: #ECF0F1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        /* Container */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-top: 2rem;
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 2rem;
            color: white;
            text-align: center;
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .form-body {
            padding: 2rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid var(--gray-light-color);
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255,107,107,0.1);
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #ff8585);
            color: white;
        }

        .btn-secondary {
            background: var(--gray-light-color);
            color: var(--dark-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid var(--gray-light-color);
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-success {
            background: var(--success-color);
            color: white;
        }

        .alert-danger {
            background: var(--danger-color);
            color: white;
        }

        /* Avatar Preview */
        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-upload {
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Password Toggle */
        .password-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-color);
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
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
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('services.manage') }}" class="nav-link">
                    <i class="bi bi-gear"></i> Services
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="nav-link">
                    <i class="bi bi-envelope"></i> Messages
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="bi bi-person"></i> Profil
                </a>
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
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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

        <div class="form-card">
            <div class="form-header">
                <h1 class="form-title">Modifier l'utilisateur</h1>
                <p class="form-subtitle">Modifier les informations de {{ $user->first_name }} {{ $user->last_name }}</p>
            </div>

            <div class="form-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <img src="{{ asset($user->profile_picture ?? 'img/default-avatar.png') }}" 
                                 alt="Avatar" 
                                 id="avatarPreview">
                        </div>
                        <input type="file" 
                               name="profile_picture" 
                               id="profile_picture" 
                               accept="image/*" 
                               style="display: none;">
                        <button type="button" 
                                class="btn btn-secondary" 
                                onclick="document.getElementById('profile_picture').click()">
                            <i class="bi bi-camera"></i>
                            Changer l'avatar
                        </button>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name" class="form-label">Prénom</label>
                            <input type="text" 
                                   id="first_name" 
                                   name="first_name" 
                                   class="form-input" 
                                   value="{{ $user->first_name }}" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="form-label">Nom</label>
                            <input type="text" 
                                   id="last_name" 
                                   name="last_name" 
                                   class="form-input" 
                                   value="{{ $user->last_name }}" 
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               value="{{ $user->email }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="form-input" 
                               value="{{ $user->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Adresse</label>
                        <input type="text" 
                               id="address" 
                               name="address" 
                               class="form-input" 
                               value="{{ $user->address }}">
                    </div>

                    <div class="form-grid">
                        <div class="form-group password-group">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-input">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <div class="form-group password-group">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="form-input">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2"></i> Sauvegarder les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Prévisualisation de l'avatar
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Afficher/Masquer le mot de passe
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        // Animation du formulaire
        document.addEventListener('DOMContentLoaded', function() {
            const formCard = document.querySelector('.form-card');
            formCard.style.opacity = '0';
            formCard.style.transform = 'translateY(20px)';
            formCard.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                formCard.style.opacity = '1';
                formCard.style.transform = 'translateY(0)';
            }, 100);
        });

        // Validation personnalisée
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');
            
            if (password.value || confirmation.value) {
                if (password.value !== confirmation.value) {
                    e.preventDefault();
                    alert('Les mots de passe ne correspondent pas.');
                }
            }
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
