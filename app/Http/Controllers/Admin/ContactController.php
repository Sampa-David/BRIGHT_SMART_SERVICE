<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Mail\ContactResponseMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string',
        ]);

        $contact->update([
            'admin_response' => $validated['admin_response'],
            'status' => 'responded',
            'response_sent_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Réponse envoyée avec succès.');
    }

    public function respond(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'response' => 'required|string',
        ]);

        $contact->update([
            'admin_response' => $validated['response'],
            'status' => 'responded',
            'response_sent_at' => now(),
        ]);

        // Send email to the contact with the response message
        Mail::to($contact->email)->send(new ContactResponseMail($contact, $validated['response']));

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Réponse envoyée avec succès.');
    }
}