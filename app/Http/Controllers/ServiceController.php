<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function adminIndex()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function ServiceList(){
        $services=Service::all();
        return view('services.ServiceList',compact('services'));
    }

    public function ServiceShow($id){
        $service = Service::findOrFail($id);
        $otherServices = Service::where('id', '!=', $id)->take(4)->get();
        $footerServices = Service::take(5)->get(); // Récupère 5 services pour le footer
        return view('services.show', compact('service', 'otherServices', 'footerServices'));
    }

    public function ServiceEdit($id){
        $service=Service::findOrFail($id);
        return view('services.ServiceEdit',compact('service'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name'=>'required|string|max:200|unique:services,name',
            'description'=>'required|string|',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:10048'
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/services'), $imageName);
            $data['image'] = 'uploads/services/'.$imageName;
        }
        Service::create($data);
        return redirect()->route('services.manage')->with('success','Service créé avec succès');
    }

    public function ServiceUpdate(Request $request, string $id){
        $service = Service::findOrFail($id);
        $data = $request->validate([
            'name'=>'required|string|max:200|unique:services,name,'.$service->id,
            'description'=>'required|string',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:10048'
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/services'), $imageName);
            $data['image'] = 'uploads/services/'.$imageName;
        }
        $service->update($data);
        return redirect()->back()->with('success','Service mis à jour avec succès');
    }

    public function ServiceDestroy(string $id){
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.ServiceList')->with('success','Service supprimé avec succès');
    }
}
