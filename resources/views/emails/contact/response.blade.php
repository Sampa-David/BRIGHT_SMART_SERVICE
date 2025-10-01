@component('mail::message')
# Bonjour {{ $contact->name }},

Merci d'avoir contacté {{ config('app.name') }}. Voici notre réponse à votre message :

{{ $responseMessage }}

Si vous avez d'autres questions, n'hésitez pas à nous recontacter.

Cordialement,<br>
L'équipe {{ config('app.name') }}
@endcomponent