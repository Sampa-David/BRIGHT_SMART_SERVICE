@component('mail::message')
# Nouveau message de contact

**De**: {{ $contact->name }}  
**Email**: {{ $contact->email }}  
@if($contact->phone)
**Téléphone**: {{ $contact->phone }}  
@endif
**Méthode de contact préférée**: {{ $contact->contact_method }}

**Message**:  
{{ $contact->message }}

# Informations supplémentaires
**Date**: {{ $contact->created_at->format('d/m/Y H:i') }}  
**ID du message**: {{ $contact->id }}

Merci,  
{{ config('app.name') }}
@endcomponent
