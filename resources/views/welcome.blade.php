<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="Votre solution digitale professionnelle">
    <meta name="keywords" content="digital, web, services">

        @include('partials.favicons')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
        <link rel="stylesheet" href="{{ asset("css/views/welcome.blade.css") }}">
</head>

<body class="index-page">
    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                <img src="{{ asset('img/bright.jpg') }}" alt="{{ config('app.name') }}">
                <h1 class="sitename">{{ config('app.name') }}</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{route('welcome')}}" class="active">Accueil</a></li>
                    <li><a href="{{route('services.ServiceList')}}">Services</a></li>
                    
                    @auth
                        <li class="dropdown">
                            <a href="#"><span>Mon compte</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="{{ route('profile.edit') }}">Mon profil</a></li>
                                
                                @if(Auth::user()->hasRole('superadmin'))
                                    <li><a href="{{ route('superadmin.dashboard') }}">Administration</a></li>
                                    <li><a href="{{ route('superadmin.statistics') }}">Statistiques</a></li>
                                    <li><a href="{{ route('services.manage') }}">Gérer les services</a></li>
                                    <li><a href="{{ route('superadmin.roles') }}">Gestion des rôles</a></li>
                                    <li><a href="{{ route('admin.users.index') }}">Gestion des utilisateurs</a></li>
                                @elseif(Auth::user()->hasRole('admin'))
                                    <li><a href="{{ route('admin.dashboard') }}">Administration</a></li>
                                    <li><a href="{{ route('services.manage') }}">Gérer les services</a></li>
                                    <li><a href="{{route('admin.users.index')}}">Gestion des utilisateurs</a></li>
                                    <li><a href="{{ route('admin.contacts.index') }}">Messages</a></li>
                                @else
                                    <li><a href="{{ route('client.dashboard') }}">Mon tableau de bord</a></li>
                                    <li><a href="{{ route('ServiceRequest.AllRequest') }}">Mes demandes</a></li>
                                    <li><a href="{{ route('testimonials.Create') }}">Laisser un avis</a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </a></li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <li><a href="{{ route('auth.login') }}">Connexion</a></li>
                        <li><a href="{{ route('auth.register') }}" target="_blank">Inscription</a></li>
                    @endauth
                    <li><a href="{{route('contact')}}">Contact</a></li>
                    <li><a href="{{route('about')}}">À propos</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            

        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="hero-content">
                            <h1>Transformez Votre Présence Digitale</h1>
                            <p style="font-size: 1.5rem; color: #ffffff; font-weight: 500; line-height: 1.6; margin-bottom: 2rem; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);">Nous créons des solutions digitales innovantes qui stimulent votre croissance et élèvent votre marque. Du développement web au marketing digital, nous sommes vos partenaires dans la transformation digitale.</p>
                            <div class="hero-buttons">
                                <a href="{{route('services.ServiceList')}}" class="btn btn-primary">Nos Services</a>
                                <a href="#portfolio" class="btn btn-outline">Nos Réalisations</a>
                            </div>
                            <div class="hero-stats">
                                <div class="stat-item">
                                    <span class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1"></span>
                                    <span class="stat-label">Projets Réalisés</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="95" data-purecounter-duration="1"></span>
                                    <span class="stat-label">Clients Satisfaits</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="1"></span>
                                    <span class="stat-label">Experts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="hero-visual">
                            <div class="hero-image">
                                <img src="{{ asset('img/bright.jpg') }}" alt="Hero Image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <div class="hero-bg-elements">
                <div class="bg-shape shape-1"></div>
                <div class="bg-shape shape-2"></div>
                <div class="bg-particles"></div>
            </div>
            <div class="btn-getstarted-container">
                <form action="{{route('services.ServiceList')}}" method="GET">
                    <button type="submit" class="btn-getstarted">
                        <i class="bi bi-rocket-takeoff me-2"></i>Commencer
                    </button>
                </form>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="services section">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Nos Services</h2>
                    <p>Découvrez notre gamme complète de services automobiles pour entretenir et réparer votre véhicule</p>
                </div>

                <div class="row gy-4">
                    @forelse($services as $service)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="service-card">
                                <div class="service-icon">
                                    <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="img-fluid">
                                </div>

                                <h4>
                                    <a href="{{ route('services.ServiceShow', $service->id) }}">
                                        {{ $service->name }}
                                    </a>
                                </h4>

                                <p>{{ Str::limit($service->description, 150) }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="price-tag">
                                        
                                    </span>
                                    
                                    <a href="{{ route('services.ServiceShow', $service->id) }}" class="service-link">
                                        En savoir plus 
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-services" data-aos="fade-up">
                                <div class="text-center py-5">
                                    <i class="bi bi-clipboard-x display-4 text-muted"></i>
                                    <h3 class="mt-4">Aucun service disponible</h3>
                                    <p class="text-muted">Nos services sont en cours de configuration. Revenez bientôt !</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="services-cta text-center" data-aos="zoom-in">
                            <h3>Besoin d'un service spécifique ?</h3>
                            <p>Contactez-nous pour discuter de vos besoins et obtenir un devis personnalisé</p>
                            <a href="{{route('contact')}}" class="btn">
                                <i class="bi bi-chat-dots-fill me-2"></i>
                                Nous contacter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <!-- À propos -->
                    <div class="col-lg-4 col-md-12">
                        <div class="footer-about">
                            <div class="logo d-flex align-items-center">
                                <img src="{{ asset('img/logo.webp') }}" alt="{{ config('app.name') }}">
                                <span>{{ config('app.name') }}</span>
                            </div>
                            <p>Nous créons des solutions digitales innovantes pour transformer votre présence en ligne et stimuler votre croissance.</p>
                            <div class="social-links d-flex mt-4">
                                <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
                                <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Liens utiles -->
                    <div class="col-lg-2 col-6">
                        <div class="footer-links">
                            <h4>Liens utiles</h4>
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <a href="#hero">Accueil</a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#about">À propos</a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#services">Services</a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Nos services -->
                    <div class="col-lg-2 col-6">
                        <div class="footer-links">
                            <h4>Nos services</h4>
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <a href="#">Network administration</a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design </a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#">Alarm System</a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#">Video Door Phone</a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#">Software Engineering</a></li>
                                <li><i class="bi bi-chevron-right"></i> <a href="#">Camera of Security</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="col-lg-4 col-md-12">
                        <div class="footer-contact">
                            <h4>Contactez-nous</h4>
                            <p>
                                <i class="bi bi-geo-alt"></i>
                                kano<br>
                                Bertoua, Cameroun<br><br>
                                <i class="bi bi-phone"></i> <a href="tel:+33123456789">+237 6 88 66 16 42</a><br>
                                <i class="bi bi-envelope"></i> <a href="mailto:contact@example.com">njonoussistephen@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong>. Tous droits réservés</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="credits">
                            <a href="#">Mentions légales</a> | 
                            <a href="#">Politique de confidentialité</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Scroll Top Button -->
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>

