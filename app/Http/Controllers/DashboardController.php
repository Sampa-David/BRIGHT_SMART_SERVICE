<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Contact;
use App\Models\TeamMember;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirige vers le tableau de bord approprié
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($user->hasRole('superadmin')) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('client.dashboard');
    }


    /**
     * Affiche le tableau de bord Super administrateur
     */

    public function superAdminDashboard(){
        /** @var User $user */
        $user = Auth::user();
        
        // Vérification stricte pour le superadmin
        if ($user->email !== 'njonoussis@gmail.com' || !$user->hasRole('superadmin')) {
            Log::warning('Tentative d\'accès non autorisé au dashboard superadmin', [
                'user_email' => $user->email,
                'roles' => $user->roles()->pluck('slug')
            ]);
            return redirect()->route('client.dashboard')
                ->with('error', 'Accès non autorisé au dashboard superadmin.');
        }

        // Récupération des statistiques pour le tableau de bord
        $stats = [
            'total_admins' => User::whereHas('roles', function($q) {
                $q->where('slug', 'admin');
            })->count(),
            'total_clients' => User::whereHas('roles', function($q) {
                $q->where('slug', 'client');
            })->count(),
            'total_services' => Service::count(),
            'total_requests' => ServiceRequest::count(),
            'pending_requests' => ServiceRequest::where('status', 'pending')->count(),
            'new_messages' => Contact::where('status', 'unread')->count(),
            'active_users' => User::where('status', 'active')->count()
        ];

        // Récupération des administrateurs pour le tableau
        $admins = User::whereHas('roles', function($q) {
            $q->where('slug', 'admin');
        })->take(5)->get();

        return view('dashboards.superadmin', compact('stats', 'admins'))
            ->with('success', 'Bienvenue dans votre tableau de bord Super Admin');

        // Récupération des administrateurs
        $admins = User::whereHas('roles', function($q) {
            $q->where('slug', 'admin');
        })->take(5)->get();

        $stats=[
            'pending_requests' => ServiceRequest::where('status','pending')->count(),
            'total_services'=>Service::count(),
            'new_message'=>Contact::where('status','unread')->count(),
            'active_clients'=>User::where('status','active')->count(),
        ];

        $service_requests=ServiceRequest::with('users','services')->latest()->take(5)->get();

        return view('dashboards.superadmin',compact('stats','service_requests'))->with('success','Connexion reussie');
    }
    /**
     * Affiche le tableau de bord administrateur
     */
    public function adminDashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Vérifie si l'utilisateur est autorisé
        if (!$user->hasRole('admin')) {
            return redirect()->route('client.dashboard')
                ->with('error', 'Accès non autorisé.');
        }
         

        // Statistiques globales
        $stats = [
            'pending_requests' => ServiceRequest::where('status', 'pending')->count(),
            'total_services' => Service::count(),
            'new_messages' => Contact::where('status', 'new')->count(),
            'active_clients' => User::where('status', 'active')->count(),
            'total_message' => Contact::count(),
            'total_users' => User::count(),
            'total_team_members' => TeamMember::count()
        ];

        // Données pour chaque section
        $services = Service::orderBy('created_at', 'desc')->get();
        $recent_requests = ServiceRequest::with('user', 'service')->latest()->take(10)->get();
        $clients = User::where('role', 'client')->orderBy('created_at', 'desc')->get();
        $teamMembers = TeamMember::with('department')->get();
        $departments = Department::all();
        $users = User::orderBy('created_at', 'desc')->get();
        $contacts = Contact::orderBy('created_at', 'desc')->get();

        // Statistiques pour les graphiques
        $monthly_stats = ServiceRequest::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $yearly_stats = ServiceRequest::selectRaw('EXTRACT(YEAR FROM created_at) as year, COUNT(*) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $monthly_labels = $monthly_stats->pluck('month');
        $monthly_services = $monthly_stats->pluck('total');
        $yearly_labels = $yearly_stats->pluck('year');
        $yearly_services = $yearly_stats->pluck('total');

        return view('dashboards.admin', compact(
            'stats',
            'services',
            'recent_requests',
            'clients',
            'teamMembers',
            'departments',
            'users',
            'contacts',
            'monthly_labels',
            'monthly_services',
            'yearly_labels',
            'yearly_services',
            'user'  // Ajout de l'utilisateur connecté
        ));
    }

    /**
     * Affiche le tableau de bord client
     */
    public function clientDashboard()
    {        /** @var User $user */        /** @var User $user */
        $user = Auth::user();
        
        $data = [
            'my_requests' => ServiceRequest::where('user_id', $user->id)
                ->with('service')
                ->latest()
                ->take(5)
                ->get(),
            'active_services' => ServiceRequest::where('user_id', $user->id)
                ->where('status', 'active')
                ->count(),
            'completed_services' => ServiceRequest::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
        ];

        return view('dashboards.client', compact('data'));
    }

    /**
     * Affiche les statistiques générales
     */
    // Liste des administrateurs
    public function adminsList()
    {
        $admins = User::whereHas('roles', function($q) {
            $q->where('slug', 'admin');
        })->paginate(10);

        return view('dashboards.admins.index', compact('admins'));
    }

    // Édition d'un administrateur
    public function editAdmin(User $admin)
    {
        return view('dashboards.admins.edit', compact('admin'));
    }

    // Suppression d'un administrateur
    public function deleteAdmin(User $admin)
    {
        $admin->delete();
        return redirect()->route('superadmin.admins')
            ->with('success', 'Administrateur supprimé avec succès.');
    }

    public function statistics()
    {
        /** @var User $user */
        $user = Auth::user();
        $admin = $user->role ='admin' || $user->hasRole('admin');
        // Vérifie si l'utilisateur est autorisé
        if (!($user->role ='admin' || $user->hasRole('admin'))) {
            return redirect()->route('client.dashboard')
                ->with('error', 'Accès non autorisé.');
        }

        $monthly_stats = ServiceRequest::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $service_stats = Service::withCount('service_requests')
            ->orderBy('service_requests_count', 'desc')
            ->take(10)
            ->get();

        return view('dashboards.statistics', compact('monthly_stats', 'service_stats'));
    }

    public function makeAdmin(Request $request, $user){
        /** @var User $authenticatedUser */
        $authenticatedUser = Auth::user();
        try {
            if ( !$authenticatedUser->hasRole('superadmin')) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Non autorisé à effectuer cette action',
                    'redirect_url' => route('superadmin.dashboard'),
                    'timeout' => 2000
                ], 403);
            }
            
            $targetUser = User::findOrFail($user);
            
            // Vérifie si l'utilisateur est déjà administrateur
            if ($targetUser->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => "❌ L'utilisateur {$targetUser->name} est déjà administrateur",
                    'redirect_url' => route('superadmin.dashboard'),
                    'timeout' => 2000
                ]);
            }

            // Récupère ou crée le rôle admin
            $adminRole = Role::where('slug', 'admin')->first();
            if (!$adminRole) {
                $adminRole = Role::create([
                    'name' => 'Admin',
                    'slug' => 'admin',
                    'description' => 'Administrateur du système avec certains privilèges'
                ]);
            }

            // Attache le rôle à l'utilisateur
            $targetUser->roles()->attach($adminRole->id);
            Log::info("Rôle administrateur assigné à {$targetUser->name} avec succès");

            return response()->json([
                'success' => true,
                'message' => "✅ L'utilisateur {$targetUser->name} est maintenant Administrateur",
                'redirect_url' => route('superadmin.dashboard'),
                'timeout' => 2000
            ]);

        } catch (\Exception $e) {
            Log::error("Erreur lors de l'assignation du rôle admin: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "❌ Une erreur est survenue lors de l'assignation du rôle administrateur",
                'redirect_url' => route('superadmin.dashboard'),
                'timeout' => 2000
            ], 500);
        }
    }

    public function revokeAdmin(Request $request, $user){
        /** @var User $authenticatedUser */
        $authenticatedUser = Auth::user();
        try {
            Log::info("Tentative de révocation des droits admin pour l'utilisateur ID: {$user}");
            
            if ( !$authenticatedUser->hasRole('superadmin')) {
                Log::warning("Tentative non autorisée de révocation des droits admin par {$authenticatedUser->email}");
                return response()->json([
                    'success' => false,
                    'message' => '❌ Non autorisé à effectuer cette action',
                    'redirect_url' => route('superadmin.dashboard'),
                    'timeout' => 2000
                ], 403);
            }
            
            $targetUser = User::findOrFail($user);
            Log::info("Utilisateur trouvé: {$targetUser->name}");
            
            // Vérifie si l'utilisateur a le rôle admin
            if (!$targetUser->hasRole('admin')) {
                Log::warning("Tentative de révocation pour un utilisateur non admin: {$targetUser->name}");
                return response()->json([
                    'success' => false,
                    'message' => "❌ L'utilisateur {$targetUser->name} n'est pas administrateur",
                    'redirect_url' => route('superadmin.dashboard'),
                    'timeout' => 2000
                ]);
            }
            
            // Récupérer le rôle client
            $clientRole = Role::where('slug', 'client')->first();
            if (!$clientRole) {
                Log::info("Création du rôle client car non existant");
                $clientRole = Role::create([
                    'name' => 'Client',
                    'slug' => 'client',
                    'description' => "Client standard de l'entreprise"
                ]);
            }

            // Détacher le rôle admin et attacher le rôle client
            $adminRole = Role::where('slug', 'admin')->first();
            if ($adminRole) {
                Log::info("Détachement du rôle admin pour {$targetUser->name}");
                $targetUser->roles()->detach($adminRole->id);
            }

            Log::info("Attachement du rôle client pour {$targetUser->name}");
            $targetUser->roles()->attach($clientRole->id);
            
            Log::info("Rôle admin révoqué avec succès pour {$targetUser->name}");

            return response()->json([
                'success' => true,
                'message' => "✅ Les droits administrateur de {$targetUser->name} ont été révoqués",
                'redirect_url' => route('superadmin.dashboard'),
                'timeout' => 2000
            ]);

        } catch (\Exception $e) {
            Log::error("Erreur lors de la révocation du rôle admin: " . $e->getMessage(), [
                'user_id' => $user,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            $errorMessage = "❌ Une erreur est survenue lors de la révocation du rôle administrateur";
            if (app()->environment('local')) {
                $errorMessage .= ": " . $e->getMessage();
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'redirect_url' => route('superadmin.dashboard'),
                'timeout' => 2000
            ], 500);
        }
    }

    /**
     * Affiche la page de gestion des rôles
     */
    public function rolesManagement()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Vérification stricte pour le superadmin
        if ( !$user->hasRole('superadmin')) {
            return redirect()->route('client.dashboard')
                ->with('error', 'Accès non autorisé à la gestion des rôles.');
        }

        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        return view('dashboards.role-management', compact('users'));
    }
}
