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
    
    <!-- CSS Files -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Modal Image Picker */
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }

        .image-picker-modal .modal-dialog {
            max-width: 600px;
        }

        .image-picker-modal .modal-header {
            background: linear-gradient(135deg, #1B1464 0%, #2d1f6d 100%);
            color: white;
            border: none;
        }

        .image-picker-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .image-picker-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .image-option-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9f9f9;
            text-decoration: none;
            color: #333;
        }

        .image-option-btn:hover {
            border-color: #FF6B00;
            background: rgba(255, 107, 0, 0.05);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .image-option-btn i {
            font-size: 2.5rem;
            color: #FF6B00;
            margin-bottom: 1rem;
        }

        .image-option-btn span {
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Web Search Results */
        .web-search-container {
            display: none;
        }

        .search-input-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .search-input-group input {
            flex: 1;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            max-height: 400px;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .image-gallery-item {
            position: relative;
            cursor: pointer;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .image-gallery-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            display: block;
        }

        .image-gallery-item:hover {
            border-color: #FF6B00;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }

        .image-gallery-item.selected {
            border-color: #FF6B00;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.5);
        }

        .image-gallery-item.selected::after {
            content: '✓';
            position: absolute;
            top: 5px;
            right: 5px;
            background: #FF6B00;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #FF6B00;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-results {
            text-align: center;
            padding: 2rem;
            color: #999;
        }

        .btn-group-custom {
            display: flex;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .btn-group-custom button {
            flex: 1;
        }

        .hidden {
            display: none;
        }
    </style>
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
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="serviceForm" action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label">Nom du service</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        required
                                        maxlength="10"
                                    >
                                    <div class="form-text">Maximum 10 caractères</div>
                                    <div class="invalid-feedback"></div>
                                </div>

                                
                                </div>

                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        id="description" 
                                        name="description" 
                                        rows="4" 
                                        required
                                    >{{ old('description') }}</textarea>
                                    
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="image" class="form-label">Image du service</label>
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
                                    <div class="form-text">Format accepté : JPG, JPEG, PNG. Taille max : 2MB</div>
                                    <div class="invalid-feedback"></div>
                                    <div id="imagePreview" class="mt-3"></div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Créer le service
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
                &copy; {{ date('Y') }} Bright Smart Service. Tous droits réservés.
            </div>
        </div>
    </footer>

    <!-- Modal Image Picker -->
    <div class="modal fade image-picker-modal" id="imagePickerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choisir une image</h5>
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
                <div class="modal-footer" id="modalFooter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary hidden" id="confirmImageBtn" disabled>
                        Confirmer l'image
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('serviceForm');
            const imageInput = document.getElementById('image');
            const imagePickerBtn = document.getElementById('imagePickerBtn');
            const previewContainer = document.getElementById('imagePreview');
            const maxFileSize = 2 * 1024 * 1024; // 2MB

            // Modal elements
            const modal = new bootstrap.Modal(document.getElementById('imagePickerModal'));
            const localStorageBtn = document.getElementById('localStorageBtn');
            const webSearchBtn = document.getElementById('webSearchBtn');
            const backBtn = document.getElementById('backBtn');
            const searchBtn = document.getElementById('searchBtn');
            const searchInput = document.getElementById('searchInput');
            const imageGallery = document.getElementById('imageGallery');
            const imageGalleryContainer = document.getElementById('imageGalleryContainer');
            const noResults = document.getElementById('noResults');
            const confirmImageBtn = document.getElementById('confirmImageBtn');
            const imagePickerOptions = document.getElementById('imagePickerOptions');
            const webSearchContainer = document.getElementById('webSearchContainer');

            let selectedImageUrl = null;
            let serviceName = document.getElementById('name').value;

            // Fonction de validation des champs
            const validateField = (input, min, max) => {
                const value = input.value.trim();
                const isValid = value.length >= min && value.length <= max;
                toggleError(input, isValid, `Le champ doit contenir entre ${min} et ${max} caractères`);
                return isValid;
            };

            // Fonction pour afficher/masquer les erreurs
            const toggleError = (element, isValid, errorMessage) => {
                element.classList.toggle('is-invalid', !isValid);
                const feedback = element.nextElementSibling?.nextElementSibling || element.parentElement.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = !isValid ? errorMessage : '';
                }
            };

            // Mettre à jour le nom du service en temps réel
            document.getElementById('name').addEventListener('change', function() {
                serviceName = this.value;
                searchInput.value = serviceName;
            });

            // Click sur le bouton Choisir une image
            imagePickerBtn.addEventListener('click', function() {
                serviceName = document.getElementById('name').value;
                searchInput.value = serviceName;
                modal.show();
            });

            // Click sur Stockage local
            localStorageBtn.addEventListener('click', function() {
                imageInput.click();
            });

            // Click sur Recherche Web
            webSearchBtn.addEventListener('click', function() {
                imagePickerOptions.style.display = 'none';
                webSearchContainer.style.display = 'block';
                searchInput.focus();
            });

            // Bouton Retour
            backBtn.addEventListener('click', function() {
                imagePickerOptions.style.display = 'block';
                webSearchContainer.style.display = 'none';
                imageGallery.classList.add('hidden');
                noResults.classList.add('hidden');
                imageGallery.innerHTML = '';
                selectedImageUrl = null;
                confirmImageBtn.classList.add('hidden');
                confirmImageBtn.disabled = true;
            });

            // Recherche d'images
            const searchImages = async (query) => {
                if (!query.trim()) {
                    noResults.classList.remove('hidden');
                    imageGallery.classList.add('hidden');
                    return;
                }

                imageGalleryContainer.style.display = 'flex';
                imageGallery.classList.add('hidden');
                noResults.classList.add('hidden');

                try {
                    // Utiliser Unsplash API (free tier)
                    const response = await fetch(
                        `https://api.unsplash.com/search/photos?query=${encodeURIComponent(query)}&per_page=12&orientation=landscape`,
                        {
                            headers: {
                                'Authorization': 'Client-ID e8f7f5f7f0f7f7f7f7f7f7f7f7f7f7f7'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error('Erreur lors de la recherche');
                    }

                    const data = await response.json();
                    imageGalleryContainer.style.display = 'none';

                    if (data.results && data.results.length > 0) {
                        imageGallery.classList.remove('hidden');
                        noResults.classList.add('hidden');
                        displayImages(data.results);
                    } else {
                        imageGallery.classList.add('hidden');
                        noResults.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    imageGalleryContainer.style.display = 'none';
                    noResults.classList.remove('hidden');
                    noResults.textContent = 'Erreur lors de la recherche. Veuillez réessayer.';
                }
            };

            // Afficher les images
            const displayImages = (images) => {
                imageGallery.innerHTML = '';
                images.forEach(image => {
                    const item = document.createElement('div');
                    item.className = 'image-gallery-item';
                    item.innerHTML = `<img src="${image.urls.small}" alt="${image.alt_description || 'Image'}" loading="lazy">`;
                    
                    item.addEventListener('click', () => {
                        // Désélectionner l'image précédente
                        document.querySelectorAll('.image-gallery-item.selected').forEach(el => {
                            el.classList.remove('selected');
                        });
                        
                        // Sélectionner la nouvelle image
                        item.classList.add('selected');
                        selectedImageUrl = image.urls.regular;
                        confirmImageBtn.classList.remove('hidden');
                        confirmImageBtn.disabled = false;
                    });
                    
                    imageGallery.appendChild(item);
                });
            };

            // Bouton Rechercher
            searchBtn.addEventListener('click', () => {
                searchImages(searchInput.value);
            });

            // Recherche en appuyant sur Entrée
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    searchImages(searchInput.value);
                }
            });

            // Confirmer l'image sélectionnée du web
            confirmImageBtn.addEventListener('click', async () => {
                if (!selectedImageUrl) return;

                confirmImageBtn.disabled = true;
                confirmImageBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Téléchargement...';

                try {
                    // Télécharger l'image
                    const response = await fetch(selectedImageUrl);
                    const blob = await response.blob();

                    // Créer un File à partir du blob
                    const filename = selectedImageUrl.split('/').pop().split('?')[0] || 'image.jpg';
                    const file = new File([blob], filename || 'service-image.jpg', { type: 'image/jpeg' });

                    // Affecter le fichier à l'input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    imageInput.files = dataTransfer.files;

                    // Déclencher l'événement change
                    imageInput.dispatchEvent(new Event('change', { bubbles: true }));

                    // Fermer le modal
                    modal.hide();

                    confirmImageBtn.disabled = false;
                    confirmImageBtn.innerHTML = 'Confirmer l\'image';
                } catch (error) {
                    console.error('Erreur lors du téléchargement:', error);
                    alert('Erreur lors du téléchargement de l\'image. Veuillez réessayer.');
                    confirmImageBtn.disabled = false;
                    confirmImageBtn.innerHTML = 'Confirmer l\'image';
                }
            });

            // Gestion du changement d'image (local ou web)
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validation du type de fichier
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    toggleError(this, false, 'Le format du fichier doit être JPG, JPEG ou PNG');
                    this.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }

                // Validation de la taille
                if (file.size > maxFileSize) {
                    toggleError(this, false, 'L\'image ne doit pas dépasser 2MB');
                    this.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }

                // Affichage de la preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                        <div class="preview-wrapper">
                            <img src="${e.target.result}" class="img-thumbnail" alt="Aperçu de l'image" style="max-height: 200px;">
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
                this.classList.remove('is-invalid');
                
                // Reset les variables du modal
                selectedImageUrl = null;
                imageGallery.innerHTML = '';
            });

            // Validation du formulaire
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let isValid = true;

                // Validation des champs texte
                isValid = validateField(document.getElementById('name'), 1, 10) && isValid;

                // Validation de la description
                const description = document.getElementById('description');
                const isDescValid = description.value.trim().length > 0;
                toggleError(description, isDescValid, 'La description est requise');
                isValid = isDescValid && isValid;

                // Validation de l'image
                const isImageValid = imageInput.files[0] !== undefined;
                toggleError(imageInput, isImageValid, 'Une image est requise');
                isValid = isImageValid && isValid;

                // Soumission du formulaire si tout est valide
                if (isValid) {
                    // Animation de chargement
                    const submitBtn = this.querySelector('[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';
                    
                    // Soumettre le formulaire
                    this.submit();
                } else {
                    // Scroll vers la première erreur
                    const firstError = form.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    </script>
</body>
</html>