<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - {{config('app.name')}}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Quicksand:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset("css/views/about.blade.css") }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('img/bright.jpg') }}" alt="Logo" style="height: 40px;" class="d-inline-block align-text-top me-2">
                Bright Smart Services
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services.ServiceList') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('about') }}">À Propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notre equipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h1 class="display-4 fw-bold mb-4">Bienvenue chez Bright Smart Services</h1>
                    <p class="lead mb-4">Votre partenaire de confiance en solutions technologiques innovantes</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Histoire -->
    <section class="py-5">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Notre Histoire</h2>
                <p>Un parcours d'innovation et d'excellence</p>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                        <h4>2020 - Création</h4>
                        <p>Bright Smart Services voit le jour avec une vision claire : rendre la technologie accessible à tous.</p>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                        <h4>2022 - Expansion</h4>
                        <p>Développement de notre gamme de services et croissance de notre équipe d'experts.</p>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="300">
                        <h4>2025 - Innovation</h4>
                        <p>Lancement de nouvelles solutions technologiques innovantes pour répondre aux besoins évolutifs de nos clients.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos Valeurs -->
    <section class="values-section py-5">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Nos Valeurs</h2>
                <p>Les principes qui guident nos actions</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h3 class="feature-title">Excellence</h3>
                        <p>Nous visons l'excellence dans chaque projet, garantissant des solutions de haute qualité.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightbulb-fill"></i>
                        </div>
                        <h3 class="feature-title">Innovation</h3>
                        <p>Nous restons à la pointe de la technologie pour offrir des solutions innovantes.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3 class="feature-title">Collaboration</h3>
                        <p>Nous croyons en la force du travail d'équipe et de la collaboration avec nos clients.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos Chiffres -->
    <section class="py-5">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Nos Chiffres</h2>
                <p>L'impact de notre engagement</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Clients Satisfaits</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Projets Réalisés</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Experts</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support Client</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Engagement -->
    <section class="values-section py-5">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Notre Engagement</h2>
                <p>Une promesse de qualité et d'innovation</p>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h3 class="mb-4">Notre Mission</h3>
                    <p class="mb-4">Fournir des solutions technologiques innovantes et accessibles qui transforment la façon dont nos clients travaillent et interagissent avec la technologie.</p>
                    
                    <h3 class="mb-4">Notre Vision</h3>
                    <p>Devenir le leader de référence en solutions technologiques intelligentes, en créant un impact positif sur la société à travers l'innovation et l'excellence.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="{{ asset('img/bright.jpg') }}" alt="Notre équipe" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </section>

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

