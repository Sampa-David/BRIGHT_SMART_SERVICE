<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class TestimonialsController extends Controller
{
    // Affiche la liste des témoignages approuvés
    public function TestimonialsList(){
        $testimonials = Testimonial::where('is_approved', true)->latest()->paginate(10);
        return view('testimonials.List', compact('testimonials'));
    }

    // Affiche le formulaire de création d'un témoignage
    public function TestimonialsCreate(){
        return view('testimonials.Create');
    }

    // Enregistre un nouveau témoignage
    public function TestimonialsStore(Request $request){
        $data = $request->validate([
            'content' => 'required|string|max:500',
        ]);
        $data['user_id'] = Auth::id();
        $data['is_approved'] = false;
        Testimonial::create($data);
        return redirect()->route('testimonials.List')->with('success', 'Votre témoignage a été soumis et sera publié après validation.');
    }

    // Affiche un témoignage spécifique
    public function TestimonialsShow($id){
        $testimonial = Testimonial::findOrFail($id);
        return view('testimonials.Show', compact('testimonial'));
    }

    // Pour l'admin : approuver un témoignage
    public function TestimonialsApprove($id){
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_approved = true;
        $testimonial->save();
        return redirect()->back()->with('success', 'Témoignage approuvé avec succès.');
    }

    // Pour l'admin : supprimer un témoignage
    public function TestimonialsDestroy($id){
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return redirect()->back()->with('success', 'Témoignage supprimé avec succès.');
    }
}
