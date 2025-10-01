<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class ServiceRequestController extends Controller
{
    
    // Liste paginée des demandes de service (plus lisible pour l'admin)
    public function ServiceRequestList(){
        $listRequest = ServiceRequest::latest()->paginate(10);
        return view('ServiceRequest.AllRequest', compact('listRequest'));
    }

    // Affiche le formulaire d'édition d'une demande
    public function ServiceRequestEdit($id){
        $editRequest = ServiceRequest::findOrFail($id);
        return view('ServiceRequest.ServiceRequestEdit', compact('editRequest'));
    }

    // Affiche le détail d'une demande
    public function ServiceRequestShow($id){
        $showRequest = ServiceRequest::findOrFail($id);
        return view('ServiceRequest.ServiceRequestShow', compact('showRequest'));
    }

    // Enregistre une nouvelle demande de service
    public function ServiceRequestStore(Request $request){
        $data = $request->validate([
            'details' => 'required|string|max:240',
            'status' => 'required|in:en attente,en cours,termine,annulee',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'nullable|exists:users,id',
        ]);
        ServiceRequest::create($data);
        return redirect()->route('ServiceRequest.AllRequest')->with('success','Requête créée avec succès');
    }

    // Met à jour une demande de service
    public function ServiceRequestUpdate(Request $request, $id){
        $serviceRequest = ServiceRequest::findOrFail($id);
        $data = $request->validate([
            'details' => 'required|string|max:240',
            'status' => 'required|in:en attente,en cours,termine,annulee',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'nullable|exists:users,id',
        ]);
        $serviceRequest->update($data);
        return redirect()->back()->with('success','Requête modifiée avec succès');
    }

    // Supprime une demande de service
    public function ServiceRequestDestroy($id){
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->delete();
        return redirect()->back()->with('success','Requête supprimée avec succès');
    }
}