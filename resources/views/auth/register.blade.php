<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}} - Inscription</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS -->
    <link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    
    <!-- Main CSS -->
    <link href="{{asset('css/auth.css')}}" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">
                    <img src="{{asset('img/logo.webp')}}" alt="{{config('app.name')}}">
                </div>
                <h1>Inscription</h1>
                <p>Créez votre compte {{config('app.name')}}</p>
            </div>

        @if(session('message'))
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <span>{{session('message')}}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                <span>{{session('success')}}</span>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-error">
                <i class="bi bi-exclamation-circle"></i>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                       placeholder="Choisissez un nom d'utilisateur" required>
                <i class="bi bi-person input-icon"></i>
                @error('username')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                       placeholder="Votre nom complet" required>
                <i class="bi bi-person-badge input-icon"></i>
                @error('name')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                       placeholder="exemple@email.com" required>
                <i class="bi bi-envelope input-icon"></i>
                @error('email')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                       placeholder="Votre numéro de téléphone">
                <i class="bi bi-telephone input-icon"></i>
                @error('phone')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="profile_picture">Photo de profil</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                <i class="bi bi-camera input-icon"></i>
                @error('profile_picture')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" 
                       placeholder="Choisissez un mot de passe sécurisé" required>
                <i class="bi bi-lock input-icon"></i>
                @error('password')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       placeholder="Confirmez votre mot de passe" required>
                <i class="bi bi-lock-fill input-icon"></i>
            </div>

                <button type="submit" class="auth-btn">
                    <i class="bi bi-person-plus"></i>
                    Créer mon compte
                </button>
            </form>

            <div class="social-divider">
                <span>ou</span>
            </div>

            <div class="social-buttons">
                <a href="#" class="social-btn google">
                    <i class="bi bi-google"></i>
                    Google
                </a>
                <a href="#" class="social-btn facebook">
                    <i class="bi bi-facebook"></i>
                    Facebook
                </a>
            </div>

            <div class="auth-links">
                <p>Déjà un compte ? <a href="{{ route('auth.login') }}">Connectez-vous</a></p>
                <p><a href="{{ url('/') }}"><i class="bi bi-arrow-left"></i> Retour à l'accueil</a></p>
            </div>
        </div>
    </div>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Main JS File -->
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/register.js')}}"></script>
</body>
</html>
