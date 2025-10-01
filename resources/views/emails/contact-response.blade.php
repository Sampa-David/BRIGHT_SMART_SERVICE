@component('mail::message')
# Réponse à votre message

Bonjour {{ $contact->name }},

En réponse à votre message du {{ $contact->created_at->format('d/m/Y') }} :

> {{ $contact->message }}

Voici notre réponse :

{{ $responseMessage }}

N'hésitez pas à nous recontacter si vous avez d'autres questions.

Cordialement,  
L'équipe {{ config('app.name') }}
@endcomponent
