<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Chemin centralisé pour les photos de profil
    private const PROFILE_PICTURE_PATH = 'uploads/profile_pictures/';

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();
        
        // Gérer l'upload de l'image de profil
        if ($request->hasFile('profile_picture')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                File::delete(public_path($user->profile_picture));
            }

            // Créer le dossier s'il n'existe pas
            $uploadPath = public_path(self::PROFILE_PICTURE_PATH);
            if (!File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }

            // Générer un nom unique
            $image = $request->file('profile_picture');
            $imageName = 'profile_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Déplacer l'image
            $image->move($uploadPath, $imageName);
            $user->profile_picture = self::PROFILE_PICTURE_PATH . $imageName;
        }

        $user->fill($request->only(['name', 'email', 'phone', 'location']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Supprimer la photo de profil
        if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
            File::delete(public_path($user->profile_picture));
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}