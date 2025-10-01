<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class TwoFactorController extends Controller
{
    private $superAdminEmail = 'ceoLeader@gmail.com';
    private $adminEmail = 'ceobrightsmart@gmail.com';
    private $testCode = '123456'; // Code de test

    public function showEmailForm()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('auth.2fa.email', ['user' => $user]);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Vérifier si c'est le superadmin
        if ($email === $this->superAdminEmail && $user->hasRole('superadmin')) {
            Session::put('2fa_email', $email);
            Session::put('user_role', 'superadmin');
            return redirect()->route('2fa.code');
        }
        
        // Vérifier si c'est un admin
        if ($email === $this->adminEmail && $user->hasRole('admin')) {
            Session::put('2fa_email', $email);
            Session::put('user_role', 'admin');
            return redirect()->route('2fa.code');
        }

        return back()->with('error', 'Email non autorisé ou rôle incorrect.');
    }

    public function showCodeForm()
    {
        if (!Session::has('2fa_email')) {
            return redirect()->route('2fa.email');
        }

        return view('auth.2fa.code', ['code' => $this->testCode]);
    }

    public function verifyCode(Request $request)
    {
        // Augmenter la limite de temps d'exécution pour cette requête
        set_time_limit(300); // 5 minutes
        
        if (!Session::has('2fa_email')) {
            return redirect()->route('2fa.email');
        }

        $request->validate([
            'code' => 'required|string'
        ]);

        if ($request->code === $this->testCode) {
            $email = Session::get('2fa_email');
            $userRole = Session::get('user_role');
            Session::put('2fa_verified', true);
            
            // Log pour le débogage
            \Log::info('2FA Verification:', [
                'email' => $email,
                'role' => $userRole,
                'user_roles' => auth()->user()->roles()->pluck('slug')->toArray()
            ]);
            
            // Si la requête attend du JSON, on renvoie une réponse JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'role' => $userRole,
                    'message' => 'Authentification réussie'
                ]);
            }
            
            // Sinon, on fait la redirection normale
            if ($email === $this->superAdminEmail) {
                return redirect()->route('superadmin.dashboard')
                               ->with('success', 'Authentification réussie en tant que Super Admin');
            }
            
            return match($userRole) {
                'superadmin' => redirect()->route('superadmin.dashboard')
                                        ->with('success', 'Authentification réussie en tant que Super Admin'),
                'admin' => redirect()->route('admin.dashboard')
                                   ->with('success', 'Authentification réussie en tant qu\'Admin'),
                default => redirect()->route('login')
                                   ->with('error', 'Rôle non autorisé')
            };
        }

        return back()->with('error', 'Code incorrect.');
    }
}