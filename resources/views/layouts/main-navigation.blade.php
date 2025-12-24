<!-- Main Navigation -->
<header class="header" x-data="{ isOpen: false }">
    <nav class="nav-container">
        <a href="{{ route('welcome') }}" class="logo">
            <i class="bi bi-lightning-charge-fill"></i>
            Bright Smart Service
        </a>

        <div class="nav-links" :class="{ 'active': isOpen }">
            <a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                Accueil
            </a>
            <a href="{{ route('services.ServiceList') }}" class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                Services
            </a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i>
                À propos
            </a>
            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i>
                Contact
            </a>

            @auth
                @php
                    $isAdmin = Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin');
                    
                    if($isAdmin) {
                        $dashboardRoute = Auth::user()->hasRole('superadmin') ? 'superadmin.dashboard' : 'admin.dashboard';
                        $dashboardText = 'Administration';
                    } else {
                        $dashboardRoute = 'client.dashboard';
                        $dashboardText = 'Mon tableau de bord';
                    }
                @endphp

                <div class="dropdown nav-item">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route($dashboardRoute) }}" class="dropdown-item">
                                <i class="bi bi-speedometer2"></i> {{ $dashboardText }}
                            </a>
                        </li>
                        
                        @if($email === $adminEmail || $email === $superAdminEmail)
                        <li>
                            <a href="{{ route('dashboard.statistics') }}" class="dropdown-item">
                                <i class="bi bi-graph-up"></i> Statistiques
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services.manage') }}" class="dropdown-item">
                                <i class="bi bi-gear"></i> Gérer les services
                            </a>
                        </li>
                        @endif
                        
                        <li>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="bi bi-person"></i> Mon profil
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">
                    <i class="bi bi-person-plus"></i>
                    S'inscrire
                </a>
                <a href="{{ route('login') }}" class="nav-cta">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Connexion
                </a>
            @endauth
        </div>

        <button @click="isOpen = !isOpen" class="menu-toggle" :class="{ 'active': isOpen }">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
</header>