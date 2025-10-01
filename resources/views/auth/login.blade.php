<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}} - Connexion</title>
    
    <!-- Favicons -->
    <link href="{{ asset('img/bright.jpg') }}" rel="icon">
    <link href="{{ asset('img/bright.jpg') }}" rel="apple-touch-icon">

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
                    <img src="{{asset('img/bright.jpg')}}" alt="{{config('app.name')}}">
                </div>
                <h1>Connexion</h1>
                <p>Connectez-vous à votre compte {{config('app.name')}}</p>
            </div>

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
            
            <form method="post" action="{{route('login.connect')}}">
                @csrf
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="exemple@email.com" 
                        value="{{old('email')}}" 
                        required
                    >
                    <i class="bi bi-envelope input-icon"></i>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Votre mot de passe" 
                        required
                    >
                    <i class="bi bi-lock input-icon"></i>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="forgot-password">
                        <i class="bi bi-key"></i>
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit" class="auth-btn">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Se connecter
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

            @if(session('login_attempts') === 2)
                <div class="alert alert-error">
                    <i class="bi bi-question-circle"></i>
                    <a href="#">Besoin d'aide pour vous connecter ?</a>
                </div>
            @endif

            <div class="auth-links">
                <p>Vous n'avez pas de compte ? <a href="{{route('auth.register')}}">Inscrivez-vous</a></p>
                <p><a href="{{ url('/') }}"><i class="bi bi-arrow-left"></i> Retour à l'accueil</a></p>
            </div>
        </div>
    </div>
    
    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Main JS File -->
    <script src="{{asset('js/main.js')}}"></script>

    <script>
        // Animation du bouton lors de la soumission
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('.login-btn');
            button.classList.add('loading');
        });
    </script>
</body>
</html>
</body>
</html>