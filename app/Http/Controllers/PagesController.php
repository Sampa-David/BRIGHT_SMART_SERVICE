<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'contact_method' => 'required|string|in:email,whatsapp',
        ];

        // Ajouter la validation du téléphone si WhatsApp est sélectionné
        if ($request->input('contact_method') === 'whatsapp') {
            $rules['phone'] = 'required|string|regex:/^\+?[0-9]+$/';
        }

        $validated = $request->validate($rules);

        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'subject' => $validated['subject'],
            'contact_method' => $validated['contact_method'],
            'phone' => $validated['phone'] ?? null,
            'status' => 'new'
        ]);

        Mail::to(env('SERVICE_CLIENT_EMAIL'))->send(new ContactFormMail($contact));

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès !');
    }
}
