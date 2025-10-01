<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect()->route('auth.login');
        }

        $user = $request->user();
        
        // Vérification spéciale pour ceoLeader@gmail.com
        if ($user->email === 'ceoLeader@gmail.com') {
            // Forcer l'attribution du rôle superadmin
            $superadminRole = \App\Models\Role::where('slug', 'superadmin')->first();
            if ($superadminRole) {
                $user->roles()->sync([$superadminRole->id]);
                $user->update(['role' => 'superadmin']);
                \Log::info('Superadmin role forced for ceoLeader@gmail.com');
                return $next($request);
            }
        }

        // Convertir les rôles en tableau
        $rolesArray = is_array($roles) ? $roles : [$roles];

        // Vérifier si l'utilisateur a l'un des rôles requis
        $userRoles = $user->roles()->pluck('slug')->toArray();
        
        // Log pour le débogage
        \Log::info('User Roles:', ['roles' => $userRoles]);
        \Log::info('Required Roles:', ['roles' => $rolesArray]);

        if (in_array('superadmin', $userRoles)) {
            return $next($request);
        }

        foreach ($rolesArray as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }

        // Si l'utilisateur n'a pas les permissions nécessaires, rediriger selon son rôle
        if (in_array('admin', $userRoles)) {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Accès non autorisé pour ce niveau d\'administration.');
        } elseif (in_array('superadmin', $userRoles)) {
            return redirect()->route('superadmin.dashboard')
                           ->with('error', 'Accès non autorisé pour ce niveau d\'administration.');
        } else {
            return redirect()->route('client.dashboard')
                           ->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette section.');
        }
    }
}