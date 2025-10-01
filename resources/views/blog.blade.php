@extends('layouts.app')

@section('title', 'Blog - Bright Smart Service')
@section('meta_description', 'Découvrez nos articles sur les dernières tendances technologiques et innovations')

@section('content')
<div class="blog-page">
    <!-- Hero Section -->
    <section class="blog-hero position-relative">
        <div class="container text-center text-white position-relative z-2">
            <h1 class="display-4 fw-bold mb-4">Notre Blog</h1>
            <p class="lead">Restez informé des dernières actualités et tendances</p>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="blog-articles py-5">
        <div class="container">
            <!-- Featured Article -->
            <div class="featured-article mb-5">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img src="/images/blog/featured.jpg" class="w-100 h-100 object-fit-cover" alt="Article à la une">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-4">
                                <div class="badge bg-primary mb-2">À la une</div>
                                <h2 class="card-title h3">L'avenir de l'intelligence artificielle dans les entreprises</h2>
                                <p class="card-text text-muted mb-3">Comment l'IA transforme le paysage des affaires et crée de nouvelles opportunités pour les entreprises...</p>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="/images/team/member1.jpg" class="rounded-circle me-2" width="40" height="40" alt="Auteur">
                                    <div>
                                        <p class="mb-0 fw-bold">John Doe</p>
                                        <small class="text-muted">20 Sept 2025</small>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="row g-4">
                <!-- Article Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="/images/blog/article1.jpg" class="card-img-top" alt="Article 1">
                        <div class="card-body">
                            <div class="badge bg-secondary mb-2">Technologie</div>
                            <h3 class="card-title h5">5 tendances technologiques à surveiller en 2025</h3>
                            <p class="card-text text-muted">Découvrez les innovations qui façonneront notre futur...</p>
                            <div class="d-flex align-items-center mb-3">
                                <img src="/images/team/member2.jpg" class="rounded-circle me-2" width="30" height="30" alt="Auteur">
                                <small class="text-muted">Jane Smith • 18 Sept 2025</small>
                            </div>
                            <a href="#" class="btn btn-outline-primary btn-sm">Lire la suite</a>
                        </div>
                    </div>
                </div>

                <!-- Article Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="/images/blog/article2.jpg" class="card-img-top" alt="Article 2">
                        <div class="card-body">
                            <div class="badge bg-success mb-2">Innovation</div>
                            <h3 class="card-title h5">Comment optimiser votre transformation digitale</h3>
                            <p class="card-text text-muted">Les meilleures pratiques pour une transition réussie...</p>
                            <div class="d-flex align-items-center mb-3">
                                <img src="/images/team/member3.jpg" class="rounded-circle me-2" width="30" height="30" alt="Auteur">
                                <small class="text-muted">Bob Johnson • 15 Sept 2025</small>
                            </div>
                            <a href="#" class="btn btn-outline-primary btn-sm">Lire la suite</a>
                        </div>
                    </div>
                </div>

                <!-- Article Card -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="/images/blog/article3.jpg" class="card-img-top" alt="Article 3">
                        <div class="card-body">
                            <div class="badge bg-info mb-2">Conseils</div>
                            <h3 class="card-title h5">10 conseils pour sécuriser vos données</h3>
                            <p class="card-text text-muted">Protégez votre entreprise contre les cybermenaces...</p>
                            <div class="d-flex align-items-center mb-3">
                                <img src="/images/team/member4.jpg" class="rounded-circle me-2" width="30" height="30" alt="Auteur">
                                <small class="text-muted">Alice Brown • 12 Sept 2025</small>
                            </div>
                            <a href="#" class="btn btn-outline-primary btn-sm">Lire la suite</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Navigation des articles">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="h3 mb-4">Restez informé</h2>
                    <p class="text-muted mb-4">Abonnez-vous à notre newsletter pour recevoir nos derniers articles et actualités.</p>
                    <form class="newsletter-form">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Votre adresse email" aria-label="Votre adresse email">
                            <button class="btn btn-primary" type="submit">S'abonner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection