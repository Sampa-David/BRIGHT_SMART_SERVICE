@component('mail::message')
# 📞 Nouvelle demande de contact

Bonjour,

Un nouveau message a été reçu via le formulaire de contact de votre site.

---

## 👤 Informations du client

@component('mail::panel')
| **Élément** | **Détail** |
|---|---|
| **Nom** | {{ $contact->name }} |
| **Email** | [{{ $contact->email }}](mailto:{{ $contact->email }}) |
@if($contact->phone)
| **Téléphone** | {{ $contact->phone }} |
@endif
| **Méthode préférée** | {{ $contact->contact_method === 'email' ? '📧 Email' : '📱 WhatsApp' }} |
| **Date d'envoi** | {{ $contact->created_at->format('d/m/Y à H:i') }} |
@endcomponent

---

## 📝 Message reçu

@component('mail::panel')
### Sujet: {{ $contact->subject }}

{{ $contact->message }}

@endcomponent

---

## ✉️ Actions rapides

@component('mail::button', ['url' => route('contacts.show', $contact->id)])
Voir le message complet
@endcomponent

@component('mail::button', ['url' => route('contacts.show', $contact->id), 'color' => 'success'])
Répondre au client
@endcomponent

---

## 📊 Détails techniques

- **ID du message**: #{{ $contact->id }}
- **Statut**: {{ ucfirst($contact->status) }}
- **Source**: Formulaire de contact
- **Date de création**: {{ $contact->created_at->format('d/m/Y H:i:s') }}

---

Veuillez répondre dans les meilleurs délais pour offrir un excellent service client.

**Cordialement,**

{{ config('app.name') }}

---

<small style="color: #999;">
✓ Cet email a été généré automatiquement. Ne répondez pas directement à cette adresse.<br>
Pour répondre au client, utilisez le bouton "Répondre au client" ci-dessus.
</small>

@endcomponent
