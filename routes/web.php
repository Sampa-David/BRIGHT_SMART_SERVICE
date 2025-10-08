<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EquipeController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\LoginController;
// Pages principales
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ServiceRequestController;


// Health check route
Route::get('/health', function() {
    return response()->json(['status' => 'healthy'], 200);
});

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/equipe', [EquipeController::class, 'index'])->name('equipe');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [PagesController::class, 'sendMessage'])->name('contact.send');

// Authentification
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/login',[LoginController::class,'showLoginForm'])->name('auth.login');
Route::post('/login', [LoginController::class, 'login'])->name('login.connect');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes 2FA
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa', [App\Http\Controllers\Auth\TwoFactorController::class, 'showEmailForm'])->name('2fa.email');
    Route::post('/2fa/email', [App\Http\Controllers\Auth\TwoFactorController::class, 'verifyEmail'])->name('2fa.verify.email');
    Route::get('/2fa/code', [App\Http\Controllers\Auth\TwoFactorController::class, 'showCodeForm'])->name('2fa.code');
    Route::post('/2fa/code', [App\Http\Controllers\Auth\TwoFactorController::class, 'verifyCode'])->name('2fa.verify.code');
});

// Dashboard et accès protégés
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes SuperAdmin
    Route::middleware(['auth', 'verified', CheckUserRole::class . ':superadmin'])->group(function () {
        Route::prefix('dashboard')->group(function () {
            // Dashboard
            Route::get('/superadmin', [DashboardController::class, 'superAdminDashboard'])->name('superadmin.dashboard');
            Route::get('/statistics', [DashboardController::class, 'statistics'])->name('superadmin.statistics');
            
            // Gestion des rôles
            Route::get('/roles-management', [DashboardController::class, 'rolesManagement'])->name('superadmin.roles');
            Route::post('/users/{user}/make-admin', [DashboardController::class, 'makeAdmin'])->name('superadmin.admin.makeAdmin');
            Route::post('/users/{user}/revoke-admin', [DashboardController::class, 'revokeAdmin'])->name('superadmin.admin.revokeAdmin');
            
            // Gestion des administrateurs
            Route::get('/admins', [DashboardController::class, 'adminsList'])->name('superadmin.admins');
            Route::get('/admins/{admin}/edit', [DashboardController::class, 'editAdmin'])->name('superadmin.admins.edit');
            Route::delete('/admins/{admin}', [DashboardController::class, 'deleteAdmin'])->name('superadmin.admins.destroy');
        });
    });

        // Routes Admin
    Route::middleware(['auth', CheckUserRole::class.':admin,superadmin'])->prefix('admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        // Gestion des services
        Route::get('/services/manage', [ServiceController::class, 'adminIndex'])->name('services.manage');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');

        // Gestion de l'équipe
        Route::resource('team', TeamController::class);

        // Gestion des contacts (admin)
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class);
            Route::post('contacts/{contact}/respond', [App\Http\Controllers\Admin\ContactController::class, 'respond'])->name('contacts.respond');
        });

        // Gestion des utilisateurs
        Route::resource('users', UserController::class);
    });

    // Routes Client
    Route::middleware([CheckUserRole::class.':client'])->group(function () {
        Route::get('/dashboard/client', [DashboardController::class, 'clientDashboard'])->name('client.dashboard');
    });

    // Gestion des contacts (admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
        Route::post('/contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'update'])->name('contacts.update');
        Route::post('/contacts/{contact}/respond', [App\Http\Controllers\Admin\ContactController::class, 'respond'])->name('contacts.respond');
    });
    
    // Gestion des utilisateurs
    Route::resource('users', UserController::class);

   });

// Services publics
Route::get('/services', [ServiceController::class, 'ServiceList'])->name('services.ServiceList');
Route::get('/services/{id}', [ServiceController::class, 'ServiceShow'])->name('services.ServiceShow');

// Services protégés
Route::middleware(['auth', CheckUserRole::class.':admin,superadmin'])->group(function () {
    Route::get('/services/{id}/edit', [ServiceController::class, 'ServiceEdit'])->name('services.ServiceEdit');
    Route::post('/services', [ServiceController::class, 'ServiceStore'])->name('services.ServiceStore');
    Route::put('/services/{id}', [ServiceController::class, 'ServiceUpdate'])->name('services.ServiceUpdate');
    Route::delete('/services/{id}', [ServiceController::class, 'ServiceDestroy'])->name('services.ServiceDestroy');
});

// Demandes de services
Route::middleware(['auth'])->group(function () {
    // Accès admin et superadmin
    Route::middleware([CheckUserRole::class.':admin,superadmin'])->group(function () {
        Route::get('/service-requests', [ServiceRequestController::class, 'ServiceRequestList'])->name('ServiceRequest.AllRequest');
        Route::get('/service-requests/{id}/edit', [ServiceRequestController::class, 'ServiceRequestEdit'])->name('ServiceRequest.ServiceRequestEdit');
        Route::put('/service-requests/{id}', [ServiceRequestController::class, 'ServiceRequestUpdate'])->name('ServiceRequest.ServiceRequestUpdate');
        Route::delete('/service-requests/{id}', [ServiceRequestController::class, 'ServiceRequestDestroy'])->name('ServiceRequest.ServiceRequestDestroy');
    });

    // Accès client, admin et superadmin
    Route::middleware([CheckUserRole::class.':client,admin,superadmin'])->group(function () {
        Route::get('/service-requests/{id}', [ServiceRequestController::class, 'ServiceRequestShow'])->name('ServiceRequest.ServiceRequestShow');
        Route::post('/service-requests', [ServiceRequestController::class, 'ServiceRequestStore'])->name('ServiceRequest.ServiceRequestStore');
    });

});

// Testimonials
Route::middleware(['auth'])->group(function () {
    // Routes publiques des témoignages
    Route::get('/testimonials', [TestimonialsController::class, 'TestimonialsList'])->name('testimonials.List');
    Route::get('/testimonials/{id}', [TestimonialsController::class, 'TestimonialsShow'])->name('testimonials.Show');
});
    // Routes client
    Route::middleware([CheckUserRole::class.':client'])->group(function () {
        Route::get('/testimonials/create', [TestimonialsController::class, 'TestimonialsCreate'])->name('testimonials.Create');
        Route::post('/testimonials', [TestimonialsController::class, 'TestimonialsStore'])->name('testimonials.Store');
    });
    
    // Routes admin et superadmin
    Route::middleware([CheckUserRole::class.':admin,superadmin'])->group(function () {
        Route::post('/testimonials/{id}/approve', [TestimonialsController::class, 'TestimonialsApprove'])->name('testimonials.Approve');
        Route::delete('/testimonials/{id}', [TestimonialsController::class, 'TestimonialsDestroy'])->name('testimonials.Destroy');
    });

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes protégées par Supabase
Route::middleware(['supabase.auth'])->group(function () {
    Route::get('/protected-route', 'YourController@protectedMethod');
});
