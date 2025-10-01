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

    <style>
        :root {
            --default-font: "Roboto", system-ui, -apple-system, "Segoe UI", sans-serif;
            --heading-font: "Quicksand", sans-serif;
            --default-color: #1B1464;
            --accent-color: #FF6B00;
            --surface-color: #f9f9f9;
        }

        body {
            font-family: var(--default-font);
            color: var(--default-color);
            background-color: var(--surface-color);
        }

        .section-title {
            text-align: center;
            padding-bottom: 2rem;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--default-color);
            margin-bottom: 1rem;
        }

        .section-title p {
            color: #666;
        }

        .service-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .service-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .service-card:hover .service-image img {
            transform: scale(1.1);
        }

        .service-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .service-content h3 {
            font-family: var(--heading-font);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--default-color);
        }

        .service-content p {
            color: #666;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .learn-more {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: var(--default-color);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
            align-self: flex-start;
        }

        .learn-more:hover {
            background-color: var(--accent-color);
            color: white;
            transform: translateX(5px);
        }

        .learn-more i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .learn-more:hover i {
            transform: translateX(3px);
        }

        @media (max-width: 768px) {
            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
    <style>
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

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
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
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--accent-color) !important;
            font-weight: 600;
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-toggler-icon::before {
            content: "\F479";
            font-family: bootstrap-icons;
            color: var(--default-color);
            font-size: 2rem;
        }
    </style>
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
                @foreach($services as $service)
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
                @endforeach
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
