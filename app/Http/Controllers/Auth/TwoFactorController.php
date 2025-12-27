<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class TwoFactorController extends Controller
{
    private $superAdminEmail = 'njonoussis@gmail.com';
    private $testCode = '123456'; // Code de test

    public function showEmailForm()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }
        return view('auth.2fa.email', ['user' => $user]);
    }

    public function verifyEmail(Request $request)
    {
        Log::info('verifyEmail called', ['request_data' => $request->all()]);
        
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
            }
            return redirect()->route('auth.login');
        }

        $userRoles = $user->roles ? $user->roles()->pluck('slug')->toArray() : [];
        Log::info('User email verification', ['email' => $email, 'user_email' => $user->email, 'user_role' => $user->role, 'user_roles' => $userRoles]);

        // Vérifier si c'est le superadmin
        $isSuperAdmin = $email === $this->superAdminEmail && ($user->role === 'superadmin' || $user->hasRole('superadmin'));
        if ($isSuperAdmin) {
            Session::put('2fa_email', $email);
            Session::put('user_role', 'superadmin');
            Log::info('Superadmin email verified, session set', ['role' => 'superadmin']);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Email vérifié']);
            }
            return redirect()->route('2fa.code');
        }
        
        // Vérifier si c'est un admin
        $isAdmin =  ($user->role === 'admin' || $user->hasRole('admin'));
        if ($isAdmin) {
            Session::put('2fa_email', $email);
            Session::put('user_role', 'admin');
            Log::info('Admin email verified, session set', ['role' => 'admin']);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Email vérifié']);
            }
            return redirect()->route('2fa.code');
        }

        Log::warning('Email verification failed', ['email' => $email, 'superadmin_email' => $this->superAdminEmail, 'user_role' => $user->role]);
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Email non autorisé ou rôle incorrect'], 403);
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
        
        Log::info('verifyCode called', [
            'session_data' => Session::all(),
            'has_2fa_email' => Session::has('2fa_email'),
            'request_data' => $request->all()
        ]);
        
        if (!Session::has('2fa_email')) {
            Log::warning('Session 2fa_email not found');
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Session expirée'], 401);
            }
            return redirect()->route('2fa.email');
        }

        // Valider avec try-catch pour les requêtes JSON
        try {
            $validated = $request->validate([
                'code' => 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Code requis'], 422);
            }
            throw $e;
        }

        if ($request->code === $this->testCode) {
            $email = Session::get('2fa_email');
            $userRole = Session::get('user_role');
            Session::put('2fa_verified', true);
            
            // Log pour le débogage
            $userRoles = [];
            if (Auth::user()) {
                /** @var User $authUser */
                $authUser = Auth::user();
                $userRoles = $authUser->roles()->pluck('slug')->toArray();
            }
            Log::info('2FA Verification Success:', [
                'email' => $email,
                'role' => $userRole,
                'user_roles' => $userRoles
            ]);
            
            // Toujours renvoyer du JSON pour les requêtes AJAX
            return response()->json([
                'success' => true,
                'role' => $userRole,
                'message' => 'Authentification réussie'
            ]);
        }

        Log::warning('Invalid 2FA code', ['provided' => $request->code, 'expected' => $this->testCode]);
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Code incorrect'], 422);
        }
        return back()->with('error', 'Code incorrect.');
    }
}