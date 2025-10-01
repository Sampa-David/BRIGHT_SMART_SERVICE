<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'contact_method' => 'required|in:email,whatsapp',
            'phone' => 'required_if:contact_method,whatsapp|string|max:20',
        ]);

        // Sauvegarder le message dans la base de données
        $contact = Contact::create($validated);

        // Envoyer une notification à l'administrateur
        if ($validated['contact_method'] === 'email') {
            Mail::to('admin@brightsmartservice.com')->send(new ContactFormMail($contact));
        }

        // Si WhatsApp est choisi, envoyer une notification via l'API WhatsApp
        if ($validated['contact_method'] === 'whatsapp') {
            $this->sendWhatsAppNotification($contact);
        }

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons bientôt.');
    }

    private function sendWhatsAppNotification($contact)
    {
        $whatsappApiKey = env('WHATSAPP_API_KEY');
        $whatsappNumber = env('WHATSAPP_BUSINESS_NUMBER');

        if (!$whatsappApiKey || !$whatsappNumber) {
            throw new \Exception('WhatsApp API credentials not configured');
        }

        // Préparer le message de notification pour l'administrateur
        $message = "Nouveau message de contact\n\n";
        $message .= "De: {$contact->name}\n";
        $message .= "Email: {$contact->email}\n";
        $message .= "Téléphone: {$contact->phone}\n\n";
        $message .= "Message:\n{$contact->message}";

        try {
            // Utiliser l'API WhatsApp Business pour envoyer le message
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $whatsappApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://graph.facebook.com/v17.0/' . $whatsappNumber . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $contact->phone,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            if (!$response->successful()) {
                \Log::error('WhatsApp API Error: ' . $response->body());
                throw new \Exception('Failed to send WhatsApp message');
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp Notification Error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendWhatsAppResponse($contact, $response)
    {
        $whatsappApiKey = env('WHATSAPP_API_KEY');
        $whatsappNumber = env('WHATSAPP_BUSINESS_NUMBER');

        if (!$whatsappApiKey || !$whatsappNumber) {
            throw new \Exception('WhatsApp API credentials not configured');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $whatsappApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://graph.facebook.com/v17.0/' . $whatsappNumber . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $contact->phone,
                'type' => 'text',
                'text' => [
                    'body' => $response
                ]
            ]);

            if (!$response->successful()) {
                \Log::error('WhatsApp API Error: ' . $response->body());
                throw new \Exception('Failed to send WhatsApp response');
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp Response Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function adminIndex()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function adminShow(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function respond(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'response' => 'required|string'
        ]);

        // Si le contact préfère WhatsApp et qu'un numéro de téléphone est disponible
        if ($contact->contact_method === 'whatsapp' && $contact->phone) {
            $this->sendWhatsAppResponse($contact, $validated['response']);
        } else {
            // Par défaut, envoyer par email
            Mail::to($contact->email)->send(new ContactResponseMail($contact, $validated['response']));
        }

        $contact->update([
            'status' => 'responded',
            'admin_response' => $validated['response'],
            'response_sent_at' => now()
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Réponse envoyée avec succès');
    }
}
