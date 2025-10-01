<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('welcome', compact('services'));
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // TODO: Add email sending logic here
        
        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès !');
    }
}
