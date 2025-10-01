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

    <style>
        :root {
            --default-font: "Roboto", system-ui, -apple-system, "Segoe UI", sans-serif;
            --heading-font: "Quicksand", sans-serif;
            --nav-font: "Poppins", sans-serif;
            --default-color: #1B1464;
            --accent-color: #FF6B00;
            --surface-color: #f9f9f9;
        }

        body {
            font-family: var(--default-font);
            background-color: var(--surface-color);
            color: var(--default-color);
            line-height: 1.8;
        }

        /* Navbar Styles */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-family: var(--heading-font);
            font-weight: 700;
            color: var(--default-color) !important;
        }

        .nav-link {
            font-family: var(--nav-font);
            color: var(--default-color) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .nav-link.active {
            color: var(--accent-color) !important;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--default-color) 0%, #2A2A7F 100%);
            color: white;
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        /* About Sections */
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--default-color);
            margin-bottom: 1rem;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-family: var(--heading-font);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--default-color);
        }

        .team-member {
            text-align: center;
            margin-bottom: 2rem;
        }

        .team-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 0.5rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 3rem;
            margin-bottom: 3rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 2px;
            height: 100%;
            background: var(--accent-color);
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--accent-color);
        }

        .values-section {
            background-color: white;
        }
    </style>
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
