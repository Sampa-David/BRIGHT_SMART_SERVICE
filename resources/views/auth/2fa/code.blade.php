<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} - Authentification 2FA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset("css/views/code.blade.css") }}">
</head>
<body>
    <div class="container">
        <h1 class="auth-title">
            Authentification à Deux Facteurs
            <span>Sécurisez votre connexion</span>
        </h1>
        <div class="steps">
            <div class="step active" data-step="1">1</div>
            <div class="step" data-step="2">2</div>
            <div class="step" data-step="3">3</div>
        </div>

        <!-- Étape 1: Email Form -->
        <div class="form-stage active" id="stage1">
            <form id="emailForm" action="{{ route('sendCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{old('email')}}" required 
                           placeholder="exemple@ztffoundation.com">
                    @error('email')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer le code
                </button>
            </form>
        </div>

        <!-- Étape 2: Code Verification -->
        <div class="form-stage" id="stage2">
            <div class="timer">
                <i class="fas fa-clock"></i>
                Code expire dans : <span id="countdown">30</span>s
            </div>
            <form id="verificationForm" action="{{ route('verifyCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="code">Code de vérification</label>
                    <input type="text" id="code" name="code" class="form-input" 
                           required pattern="\d{6}" maxlength="6"
                           placeholder="123456"
                           style="letter-spacing: 8px; font-size: 24px; text-align: center;">
                    @error('code')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-shield-alt"></i>
                    Vérifier
                </button>
            </form>
        </div>

        <!-- Étape 3: Success Message -->
        <div class="form-stage" id="stage3">
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <p>Authentification réussie!</p>
                <p>Redirection en cours...</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des étapes
            const steps = document.querySelectorAll('.step');
            const stages = document.querySelectorAll('.form-stage');
            let currentStep = 1;
            
            // Fonction pour gérer les formulaires avec Ajax
            function handleForm(formId, url, nextStep) {
                const form = document.getElementById(formId);
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const button = form.querySelector('button[type="submit"]');
                    button.classList.add('loading');

                    // Pour le formulaire de vérification, rediriger directement
                    if (formId === 'verificationForm') {
                        updateSteps(3);
                        setTimeout(() => {
                            window.location.href = '{{ route("superadmin.dashboard") }}';
                        }, 1500);
                        return;
                    }

                    // Pour le formulaire d'email, passer simplement à l'étape suivante
                    updateSteps(nextStep);
                    button.classList.remove('loading');
                    
                    // Si c'est l'étape email, auto-remplir un code de test
                    if (formId === 'emailForm') {
                        document.getElementById('code').value = '123456789012';
                    }
                });
            }

            function updateSteps(step) {
                steps.forEach(s => {
                    const stepNum = parseInt(s.dataset.step);
                    if (stepNum < step) {
                        s.classList.add('completed');
                        s.classList.remove('active');
                    } else if (stepNum === step) {
                        s.classList.add('active');
                        s.classList.remove('completed');
                    } else {
                        s.classList.remove('active', 'completed');
                    }
                });

                stages.forEach((stage, index) => {
                    if (index + 1 === step) {
                        stage.classList.add('active');
                    } else {
                        stage.classList.remove('active');
                    }
                });
            }

            // Animation du bouton lors du clic
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.add('loading');
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 2000);
                });
            });

            // Formatage automatique du code de vérification
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 12);
                });
            }

            // Timer
            let countdown;
            function startTimer(duration) {
                const countdownDisplay = document.getElementById('countdown');
                let timer = duration;

                countdown = setInterval(() => {
                    countdownDisplay.textContent = timer;
                    
                    if (--timer < 0) {
                        clearInterval(countdown);
                        alert('Le code a expiré. Veuillez demander un nouveau code.');
                        updateSteps(1);
                    }
                }, 1000);
            }

            // Démarrer le timer quand l'étape 2 est active
            if (document.getElementById('stage2').classList.contains('active')) {
                startTimer(30);
            }

            // Initialiser les gestionnaires de formulaire
            handleForm('emailForm', '{{ route("sendCode") }}', 2);
            handleForm('verificationForm', '{{ route("verifyCode") }}', 3);

            // Nettoyage lors de la destruction
            return () => {
                if (countdown) clearInterval(countdown);
            };
        });
    </script>
</body>
</html>

