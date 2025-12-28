<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - {{config('app.name')}}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset("css/views/ServiceList.blade.css") }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('img/bright.jpg') }}" alt="Logo Bright" class="d-inline-block align-text-top">
                Bright Smart Services
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('services.ServiceList') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login') }}">Connexion</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <section class="services-section py-5">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Nos Services</h2>
                <p>Découvrez notre gamme complète de services technologiques</p>
            </div>

            <div class="row g-4">
                @forelse($services as $service)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="service-card">
                            <div class="service-image">
                                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}">
                            </div>
                            <div class="service-content">
                                <h3>{{ $service->name }}</h3>
                                <p>{{ Str::limit($service->description, 150) }}</p>
                                <a href="{{ route('services.ServiceShow', $service->id) }}" class="learn-more">
                                    En savoir plus <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h3>Aucun service disponible</h3>
                            <p>Nos services seront bientôt disponibles. Revenez nous visiter!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

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
                                @forelse($services as $service)
                                    <li>
                                        <i class="bi bi-chevron-right"></i>
                                        <span class="service-name">{{ $service->name }}</span>
                                        <a href="{{ route('services.ServiceShow', $service->id) }}" class="service-link" title="Voir {{ $service->name }}">
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-muted"><em>Aucun service disponible</em></li>
                                @endforelse
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
        <!-- AOS JS -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    </script>
</body>
</html>
