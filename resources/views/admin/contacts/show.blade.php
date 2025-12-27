<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du message - {{ config('app.name') }}</title>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <link rel="stylesheet" href="{{ asset("css/views/show.blade.css") }}">
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

