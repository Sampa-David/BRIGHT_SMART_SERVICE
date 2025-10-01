<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre Équipe - {{config('app.name')}}</title>

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
            margin-bottom: 4rem;
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

        /* Team Section */
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

        .team-member {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .member-image {
            position: relative;
            overflow: hidden;
            padding-top: 100%;
        }

        .member-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .team-member:hover .member-image img {
            transform: scale(1.05);
        }

        .member-info {
            padding: 1.5rem;
            text-align: center;
        }

        .member-name {
            font-family: var(--heading-font);
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--default-color);
            margin-bottom: 0.5rem;
        }

        .member-role {
            color: var(--accent-color);
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .member-bio {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-link {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--surface-color);
            color: var(--default-color);
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: var(--accent-color);
            color: white;
            transform: translateY(-2px);
        }

        .department-title {
            font-family: var(--heading-font);
            color: var(--default-color);
            margin: 3rem 0 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent-color);
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 0;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
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
                        <a class="nav-link" href="{{ route('about') }}">À Propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('equipe') }}">Équipe</a>
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
                    <h1 class="display-4 fw-bold mb-4">Notre Équipe</h1>
                    <p class="lead mb-4">Une équipe passionnée et experte à votre service</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section py-5">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Des Experts Passionnés</h2>
                <p>Découvrez les talents qui font la force de Bright Smart Services</p>
            </div>

            @foreach($departments as $department)
                <h3 class="department-title" data-aos="fade-up">{{ $department->name }}</h3>
                <div class="row">
                    @foreach($department->teamMembers as $member)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="team-member">
                                <div class="member-image">
                                    <img src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                                </div>
                                <div class="member-info">
                                    <h4 class="member-name">{{ $member->name }}</h4>
                                    <div class="member-role">{{ $member->role }}</div>
                                    <p class="member-bio">{{ $member->bio }}</p>
                                    <div class="social-links">
                                        @if($member->linkedin)
                                            <a href="{{ $member->linkedin }}" class="social-link" target="_blank">
                                                <i class="bi bi-linkedin"></i>
                                            </a>
                                        @endif
                                        @if($member->twitter)
                                            <a href="{{ $member->twitter }}" class="social-link" target="_blank">
                                                <i class="bi bi-twitter-x"></i>
                                            </a>
                                        @endif
                                        @if($member->email)
                                            <a href="mailto:{{ $member->email }}" class="social-link">
                                                <i class="bi bi-envelope"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
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