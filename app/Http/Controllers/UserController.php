<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    // Chemin centralisé pour les photos de profil
    private const PROFILE_PICTURE_PATH = 'uploads/profile_pictures/';

    public function index()
    {
        $users = User::all();
        return view('users.UserList', compact('users'));
    }

    
    public function show(User $user)
    {
        return view('users.UserShow', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.UserEdit', compact('user'));
    }

    /**
     * Traiter l'upload de photo de profil
     */
    private function handleProfilePictureUpload(Request $request, ?User $user = null): ?string
    {
        if (!$request->hasFile('profile_picture')) {
            return null;
        }

        $image = $request->file('profile_picture');
        
        // Valider le fichier
        if (!$image->isValid()) {
            throw new \Exception('Le fichier image n\'est pas valide');
        }

        // Supprimer l'ancienne photo si elle existe
        if ($user && $user->profile_picture && file_exists(public_path($user->profile_picture))) {
            File::delete(public_path($user->profile_picture));
        }

        // Créer le dossier s'il n'existe pas
        $uploadPath = public_path(self::PROFILE_PICTURE_PATH);
        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }

        // Générer un nom unique
        $imageName = 'profile_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Déplacer l'image
        $image->move($uploadPath, $imageName);

        return self::PROFILE_PICTURE_PATH . $imageName;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username'=>'required|string|max:20|unique:users',
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'phone'=>'nullable|string|max:20|unique:users',
            'location'=>'nullable|string|max:255',
            'region'=>'nullable|string|max:100',
            'state'=>'nullable|string|max:100',
            'profile_picture'=>'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'password'=>'required|string|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@"#$%&+]/',
        ]);

        // Gérer l'upload de photo
        $profilePictureUrl = $this->handleProfilePictureUpload($request);
        if ($profilePictureUrl) {
            $data['profile_picture'] = $profilePictureUrl;
        }

        $data['password'] = Hash::make($data['password']);
        $data['status'] = 'active';
        
        User::create($data);

        return redirect()->back()->with('success','Utilisateur créé avec succès');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username'=>'required|string|max:20|unique:users,username,'.$user->id,
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone'=>'nullable|string|max:20|unique:users,phone,'.$user->id,
            'location'=>'nullable|string|max:255',
            'region'=>'nullable|string|max:100',
            'state'=>'nullable|string|max:100',
            'profile_picture'=>'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'password'=>'nullable|string|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@"#$%&+]/',
        ]);

        // Gérer l'upload de photo
        $profilePictureUrl = $this->handleProfilePictureUpload($request, $user);
        if ($profilePictureUrl) {
            $data['profile_picture'] = $profilePictureUrl;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','Utilisateur mis à jour avec succès');
    }

    public function destroy(User $user)
    {
        // Supprimer la photo de profil
        if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
            File::delete(public_path($user->profile_picture));
        }

        $user->delete();
        return redirect()->back()->with('success','Utilisateur supprimé avec succès');
    }

    public function dashboard(){
        return view('users.dashboardUser');
    }
}

