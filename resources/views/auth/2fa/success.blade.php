<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification Réussie - BrightSmart Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4338ca;
            --success-color: #10b981;
            --text-color: #1f2937;
            --secondary-text: #6b7280;
            --background: #f3f4f6;
            --card-background: #ffffff;
            --animation-duration: 0.5s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
        }

        .success-container {
            background: var(--card-background);
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                       0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 2rem;
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .success-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--success-color));
        }

        .checkmark-circle {
            width: 80px;
            height: 80px;
            background: var(--success-color);
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scale-up var(--animation-duration) ease-out;
        }

        .checkmark-circle i {
            color: white;
            font-size: 40px;
            animation: fade-in var(--animation-duration) ease-out;
        }

        h1 {
            color: var(--text-color);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            animation: slide-up var(--animation-duration) ease-out;
        }

        p {
            color: var(--secondary-text);
            margin-bottom: 1.5rem;
            animation: slide-up var(--animation-duration) ease-out;
            animation-delay: 0.1s;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background: var(--success-color);
            animation: progress 1s linear forwards;
        }

        @keyframes scale-up {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slide-up {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes progress {
            to {
                width: 100%;
            }
        }

        .role-badge {
            display: inline-block;
            padding: 0.25rem 1rem;
            background: rgba(67, 56, 202, 0.1);
            color: var(--primary-color);
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
            animation: slide-up var(--animation-duration) ease-out;
            animation-delay: 0.2s;
        }
    </style>
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