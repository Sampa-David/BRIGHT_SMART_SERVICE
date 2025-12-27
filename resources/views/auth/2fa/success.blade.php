<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification Réussie - BrightSmart Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset("css/views/success.blade.css") }}">
</head>
<body>
    <div class="success-container">
        <div class="checkmark-circle">
            <i class="fas fa-check"></i>
        </div>
        <div class="role-badge">
            {{ auth()->user()->hasRole('superadmin') ? 'Super Administrateur' : 'Administrateur' }}
        </div>
        <h1>Authentification Réussie !</h1>
        <p>Redirection vers votre tableau de bord...</p>
        <div class="progress-bar"></div>
    </div>

    <script>
        // Redirection après l'animation
        setTimeout(() => {
            window.location.href = '{{ $redirect_url }}';
        }, 1000); // Redirection après 1 seconde
    </script>
</body>
</html>
