<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return redirect()->route('auth.register')
                   ->with('message', 'Compte introuvable ! Veuillez vous inscrire.');
        }
        
        if(!Hash::check($request->password, $user->password)){
            return back()->withErrors([
                'password'=>'Mot de passe incorrect, veuillez saisir a nouveau svp!',
            ])->withInput($request->except('password'));
            //compteur de tentative pour le password
            $attempts = session()->get('login_attempts',0) + 1;
            session(['login_attempts' => $attempts]);
        }
        
        session()->forget('login_attempts'); // connexion réussie, on réinitialise les tentatives
        
        // Attribution spéciale du rôle superadmin pour njonoussis@gmail.com
        if ($user->email === 'njonoussis@gmail.com') {
            // Forcer la vérification et l'attribution du rôle superadmin
            $superadminRole = Role::where('slug', 'superadmin')->firstOrCreate([
                'slug' => 'superadmin'
            ], [
                'name' => 'Super Administrateur',
                'description' => 'Accès complet au système'
            ]);
            
            // Mettre à jour directement le champ role dans la table users
            $user->update(['role' => 'superadmin']);
            
            // Assurer que seul le rôle superadmin est attribué
            $user->roles()->sync([$superadminRole->id]);
            
            Log::info('Role superadmin attribué à ' . $user->email);
            
            // Rafraîchir l'instance utilisateur
            $user->refresh();
        } else {
            // Pour les autres utilisateurs
            $clientRole = Role::where('slug', 'client')->firstOrCreate([
                'slug' => 'client'
            ], [
                'name' => 'Client',
                'description' => 'Utilisateur standard'
            ]);
            
            if (!$user->roles()->exists()) {
                $user->update(['role' => 'client']);
                $user->roles()->sync([$clientRole->id]);
                Log::info('Role client attribué à ' . $user->email);
            }
        }
        
        Auth::login($user);
        
        // Redirection vers 2FA pour Superadmin
        if ($user->email === 'njonoussis@gmail.com') {
            return redirect()->route('2fa.email')
                           ->with('info', 'Authentification à deux facteurs requise pour le super administrateur');
        }
        
        // Redirection basée sur le rôle pour les autres utilisateurs
        return $this->redirectBasedOnRole($user);
    }

    protected function redirectBasedOnRole($user)
    {
        // Pour les admin et superadmin, redirection vers 2FA
        if ($user->hasAnyRole(['admin', 'superadmin'])) {
            return redirect()->route('2fa.email')
                           ->with('info', 'Authentification requise en tant qu\'administrateur');
        }
        
        // Redirection selon le rôle
        if ($user->hasRole('superadmin')) {
            $redirectRoute = 'superadmin.dashboard';
        } elseif ($user->hasRole('admin')) {
            $redirectRoute = 'admin.dashboard';
        } else {
            $redirectRoute = 'client.dashboard';
        }
        
        return redirect()->route($redirectRoute)
                        ->with('success', 'Connexion réussie !');
    }

    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success','Deconnexion reussie');
    }
}
