<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Service - Administration</title>
    <meta name="description" content="Création d'un nouveau service dans l'interface d'administration">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/views/service-create.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container">
            <h1 class="admin-title">Bright<span>Smart</span> Service</h1>
            <nav class="admin-nav">
                <a href="{{ url('/') }}" class="btn btn-outline-light">
                    <i class="fas fa-home me-2"></i>Accueil
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="card-title mb-0">Créer un nouveau service</h2>
                                <a href="{{ route('services.manage') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <h5 class="alert-heading">Erreurs de validation</h5>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="serviceForm" action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Service Name Field -->
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-tag me-2"></i>Nom du service
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        placeholder="Ex: Développement web"
                                        required
                                        maxlength="50"
                                    >
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Donnez un nom clair et descriptif
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <!-- Description Field -->
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">
                                        <i class="fas fa-align-left me-2"></i>Description
                                    </label>
                                    <textarea 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        id="description" 
                                        name="description" 
                                        rows="5" 
                                        placeholder="Décrivez votre service en détail..."
                                        required
                                    >{{ old('description') }}</textarea>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Soyez complet et précis
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <!-- Image Field -->
                                <div class="form-group mb-4">
                                    <label for="image" class="form-label">
                                        <i class="fas fa-image me-2"></i>Image du service
                                    </label>
                                    <div class="input-group">
                                        <input 
                                            type="file" 
                                            class="form-control @error('image') is-invalid @enderror" 
                                            id="image" 
                                            name="image" 
                                            accept="image/jpeg,image/png,image/jpg"
                                            required
                                            style="display: none;"
                                        >
                                        <button type="button" class="btn btn-outline-secondary" id="imagePickerBtn" style="width: 100%;">
                                            <i class="fas fa-image me-2"></i>Choisir une image
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Formats acceptés: JPG, JPEG, PNG | Taille max: 2MB
                                    </div>
                                    <div class="invalid-feedback"></div>
                                    <div id="imagePreview" class="mt-3"></div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check me-2"></i>Créer le service
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="copyright">
                &copy; {{ date('Y') }} <strong>Bright Smart Service</strong> | Tous droits réservés
            </div>
        </div>
    </footer>

    <!-- Modal Image Picker -->
    <div class="modal fade image-picker-modal" id="imagePickerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-image me-2"></i>Choisir une image
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Initial Options -->
                    <div id="imagePickerOptions">
                        <div class="image-picker-options">
                            <button type="button" class="image-option-btn" id="localStorageBtn">
                                <i class="fas fa-folder-open"></i>
                                <span>Stockage local</span>
                            </button>
                            <button type="button" class="image-option-btn" id="webSearchBtn">
                                <i class="fas fa-search"></i>
                                <span>Recherche Web</span>
                            </button>
                        </div>
                    </div>

                    <!-- Web Search Container -->
                    <div class="web-search-container" id="webSearchContainer">
                        <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="backBtn">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </button>
                        
                        <div class="search-input-group">
                            <input 
                                type="text" 
                                class="form-control" 
                                id="searchInput" 
                                placeholder="Rechercher des images..."
                                value=""
                            >
                            <button type="button" class="btn btn-primary" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <div id="imageGalleryContainer" class="loading-spinner" style="display: none;">
                            <div class="spinner"></div>
                        </div>

                        <div id="imageGallery" class="image-gallery hidden"></div>
                        <div id="noResults" class="no-results hidden">Aucune image trouvée</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary hidden" id="confirmImageBtn" disabled>
                        <i class="fas fa-check me-2"></i>Confirmer l'image
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/views/service-create.js') }}"></script>
</body>
</html>