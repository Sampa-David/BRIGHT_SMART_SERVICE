<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du message - {{ config('app.name') }}</title>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4A90E2;
            --success-color: #2ECC71;
            --warning-color: #F1C40F;
            --danger-color: #E74C3C;
            --dark-color: #2C3E50;
            --gray-color: #95A5A6;
            --light-color: #F5F6FA;
            --border-radius: 8px;
            --box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .header h1 {
            color: var(--dark-color);
            font-size: 24px;
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-new {
            background-color: var(--warning-color);
            color: white;
        }

        .status-responded {
            background-color: var(--success-color);
            color: white;
        }

        .message-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 14px;
            color: var(--gray-color);
            margin-bottom: 5px;
            font-weight: 500;
        }

        .info-value {
            font-size: 16px;
            color: var(--dark-color);
        }

        .message-content {
            background-color: var(--light-color);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
        }

        .message-label {
            font-size: 14px;
            color: var(--gray-color);
            margin-bottom: 10px;
            font-weight: 500;
        }

        .response-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: border-color 0.3s;
            resize: vertical;
            min-height: 120px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .button {
            padding: 10px 20px;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .button-whatsapp {
            background-color: #25D366;
            color: white;
        }

        .button-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .response-history {
            background-color: var(--light-color);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-top: 20px;
        }

        .timestamp {
            font-size: 12px;
            color: var(--gray-color);
            margin-top: 8px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: var(--light-color);
            color: var(--dark-color);
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateX(-3px);
        }

        @media (max-width: 768px) {
            .contact-info {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="{{ route('admin.dashboard') }}" class="back-button">
                    <i class="bi bi-arrow-left"></i> Retour au dashboard
                </a>
                <h1>Détails du message</h1>
            </div>
            <span class="status-badge {{ $contact->status === 'new' ? 'status-new' : 'status-responded' }}">
                {{ $contact->status === 'new' ? 'Nouveau' : 'Répondu' }}
            </span>
        </div>

        <div class="message-card">
            <div class="contact-info">
                <div class="info-group">
                    <div class="info-label">Nom</div>
                    <div class="info-value">{{ $contact->name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $contact->email }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Méthode de contact</div>
                    <div class="info-value">{{ ucfirst($contact->contact_method) }}</div>
                </div>
                @if($contact->phone)
                <div class="info-group">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">{{ $contact->phone }}</div>
                </div>
                @endif
            </div>

            <div class="message-content">
                <div class="message-label">Message</div>
                <div>{{ $contact->message }}</div>
            </div>

            @if($contact->admin_response)
            <div class="response-history">
                <div class="message-label">Réponse envoyée</div>
                <div>{{ $contact->admin_response }}</div>
                <div class="timestamp">
                    Envoyée le {{ $contact->response_sent_at->format('d/m/Y H:i') }}
                </div>
            </div>
            @endif

            @if($contact->status === 'new')
            <form action="{{ route('admin.contacts.respond', $contact->id) }}" method="POST" class="response-form">
                @csrf
                <div class="form-group">
                    <label for="response" class="form-label">Votre réponse</label>
                    <textarea 
                        id="response" 
                        name="response" 
                        class="form-textarea"
                        required
                        placeholder="Écrivez votre réponse ici..."
                    ></textarea>
                </div>

                <div class="button-group">
                    @if($contact->contact_method === 'whatsapp')
                    <a 
                        href="https://wa.me/{{ $contact->phone }}?text={{ urlencode('Bonjour ' . $contact->name . ',') }}"
                        target="_blank"
                        class="button button-whatsapp"
                    >
                        Répondre via WhatsApp
                    </a>
                    @endif
                    <button type="submit" class="button button-primary">
                        Envoyer la réponse par email
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>

    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const messageCard = document.querySelector('.message-card');
            messageCard.style.opacity = '0';
            messageCard.style.transform = 'translateY(20px)';
            messageCard.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                messageCard.style.opacity = '1';
                messageCard.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
