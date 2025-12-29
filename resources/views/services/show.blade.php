<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $service->title }} - BrightSmart Services</title>
  <meta name="description" content="{{ $service->description }}">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('img/favicon.png') }}" rel="icon">
  <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/views/show.blade.css') }}">
</head>

<body class="service-details-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('welcome') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="{{ asset('img/logo.webp') }}" alt="BrightSmart Logo">
        <h1 class="sitename">BrightSmart</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('welcome') }}">Accueil</a></li>
          <li><a href="{{ route('welcome') }}#about">À propos</a></li>
          <li><a href="{{ route('services.ServiceList') }}" class="active">Services</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
          @auth
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">Déconnexion</button>
              </form>
            </li>
          @else
            <li><a href="{{ route('auth.login') }}">Connexion</a></li>
          @endauth
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route('contact') }}">Prendre RDV</a>
    </div>
  </header>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title">
      <div class="breadcrumbs">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}"><i class="bi bi-house"></i> Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.ServiceList') }}">Services</a></li>
            <li class="breadcrumb-item active current">{{ $service->name }}</li>
          </ol>
        </nav>
      </div>

      <div class="title-wrapper">
        <h1>{{ $service->name }}</h1>
        <p>{{ Str::limit($service->description,120) }}</p>
      </div>
    </div>

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <!-- Service Overview -->
          <div class="col-lg-8">
            <div class="service-content">
              <h2>{{ $service->name }}</h2>
              <p class="lead">{{ $service->description }}</p>

              <div class="service-image" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="img-fluid rounded">
              </div>

              <!-- Service Features -->
              <div class="service-features" data-aos="fade-up" data-aos-delay="300">
                <h4>Ce qui est inclus</h4>
                <div class="row gy-3">
                  <div class="col-md-6">
                    <div class="feature-item">
                      <i class="bi bi-graph-up-arrow flex-shrink-0"></i>
                      <div>
                        <h5>Analyse complète</h5>
                        <p>Diagnostic détaillé de vos besoins et objectifs.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="feature-item">
                      <i class="bi bi-bullseye flex-shrink-0"></i>
                      <div>
                        <h5>Solution sur mesure</h5>
                        <p>Service personnalisé selon vos exigences spécifiques.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="feature-item">
                      <i class="bi bi-shield-check flex-shrink-0"></i>
                      <div>
                        <h5>Garantie satisfaction</h5>
                        <p>Engagement qualité et support après-service.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="feature-item">
                      <i class="bi bi-clock flex-shrink-0"></i>
                      <div>
                        <h5>Service rapide</h5>
                        <p>Intervention dans les meilleurs délais.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Process Steps -->
              <div class="service-process" data-aos="fade-up" data-aos-delay="400">
                <h4>Notre processus</h4>
                <div class="process-steps">
                  <div class="step-item">
                    <div class="step-number">01</div>
                    <div class="step-content">
                      <h5>Consultation</h5>
                      <p>Évaluation détaillée de vos besoins et objectifs spécifiques.</p>
                    </div>
                  </div>
                  <div class="step-item">
                    <div class="step-number">02</div>
                    <div class="step-content">
                      <h5>Proposition</h5>
                      <p>Élaboration d'une solution personnalisée et d'un devis adapté.</p>
                    </div>
                  </div>
                  <div class="step-item">
                    <div class="step-number">03</div>
                    <div class="step-content">
                      <h5>Réalisation</h5>
                      <p>Mise en œuvre professionnelle par nos experts qualifiés.</p>
                    </div>
                  </div>
                  <div class="step-item">
                    <div class="step-number">04</div>
                    <div class="step-content">
                      <h5>Suivi</h5>
                      <p>Accompagnement et support après la réalisation du service.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="col-lg-4">
            <div class="sidebar" data-aos="fade-up" data-aos-delay="200">
              <!-- Service Quick Facts -->
              <div class="service-info">
                <h4>Détails du service</h4>
                <ul class="service-facts">
                  <li>
                    <span class="fact-label">Durée :</span>
                    <span class="fact-value">{{ $service->duration ?? '60' }} min</span>
                  </li>
                  <li>
                    <span class="fact-label">Délai :</span>
                    <span class="fact-value">Sur rendez-vous</span>
                  </li>
                  <li>
                    <span class="fact-label">Support :</span>
                    <span class="fact-value">Disponible</span>
                  </li>
                </ul>
              </div>

              <!-- Contact Form -->
              <div class="inquiry-form">
                <h4>Demander un devis</h4>
                <form action="{{ route('contact.send') }}" method="POST" class="php-email-form">
                  @csrf
                  <input type="hidden" name="service_id" value="{{ $service->id }}">
                  <div class="form-group mb-3">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Votre nom" required>
                  </div>
                  <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Votre email" required>
                  </div>
                  <div class="form-group mb-3">
                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Votre téléphone">
                  </div>
                  <div class="form-group mb-4">
                    <textarea class="form-control" name="message" rows="5" placeholder="Décrivez votre besoin..." required></textarea>
                  </div>
                  <div class="text-center">
                    <div class="loading">Chargement</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Votre message a été envoyé. Merci!</div>
                    <button type="submit" class="btn-submit w-100">Demander un devis</button>
                  </div>
                </form>
              </div>

              <!-- Autres Services -->
              @if($otherServices->count() > 0)
              <div class="other-services" data-aos="fade-up" data-aos-delay="300">
                <h4>Autres Services</h4>
                <div class="services-list">
                  @foreach($otherServices as $otherService)
                  <div class="service-item">
                    <a href="{{ route('services.ServiceShow', $otherService->id) }}" class="d-flex align-items-center">
                      <img src="{{ asset('storage/' . $otherService->image) }}" alt="{{ $otherService->name }}" class="service-thumb">
                      <div class="service-info">
                        <h5>{{ $otherService->name }}</h5>
                        <span class="price">{{ number_format($otherService->price, 2, ',', ' ') }} €</span>
                      </div>
                    </a>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif

            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer position-relative dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
            <span class="sitename">{{config('app.name')}}</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Kano</p>
            <p>Bertoua-Cameroun</p>
            <p class="mt-3"><strong>Tél:</strong> <span>+237 6 88 66 16 42</span></p>
            <p><strong>Email:</strong> <span>njonoussistephen@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Liens utiles</h4>
          <ul>
            <li><a href="{{ route('welcome') }}">Accueil</a></li>
            <li><a href="{{ route('welcome') }}#about">À propos</a></li>
            <li><a href="{{ route('services.ServiceList') }}">Services</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nos Services</h4>
          <ul>
            @foreach($footerServices as $footerService)
            <li><a href="{{ route('services.ServiceShow', $footerService->id) }}">{{ $footerService->name }}</a></li>
            @endforeach
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Informations</h4>
          <ul>
            <li><a href="#">Mentions légales</a></li>
            <li><a href="#">Politique de confidentialité</a></li>
            <li><a href="#">Conditions d'utilisation</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Support</h4>
          <ul>
            <li><a href="#">Centre d'aide</a></li>
            <li><a href="#">Service client</a></li>
            <li><a href="#">Devis personnalisé</a></li>
            <li><a href="#">Partenaires</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>&copy;<span>Copyright</span> <strong class="px-1 sitename">Bright Smart Services</strong> <span>{{ date('Y') }}. Tous droits réservés</span></p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>

</body>
</html>