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

                                <div class="form-group mb-4">
                                    <label for="title" class="form-label">Titre</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('title') is-invalid @enderror" 
                                        id="title" 
                                        name="title" 
                                        value="{{ old('title') }}"
                                        required
                                        minlength="4"
                                        maxlength="20"
                                    >
                                    <div class="form-text">Entre 4 et 20 caractères</div>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        id="description" 
                                        name="description" 
                                        rows="4" 
                                        required
                                        maxlength="100"
                                    >{{ old('description') }}</textarea>
                                    <div class="form-text">Maximum 100 caractères</div>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="price" class="form-label">Prix</label>
                                    <div class="input-group">
                                        <input 
                                            type="number" 
                                            class="form-control @error('price') is-invalid @enderror" 
                                            id="price" 
                                            name="price" 
                                            step="0.01" 
                                            value="{{ old('price') }}"
                                            required
                                        >
                                        <span class="input-group-text">€</span>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="image" class="form-label">Image du service</label>
                                    <input 
                                        type="file" 
                                        class="form-control @error('image') is-invalid @enderror" 
                                        id="image" 
                                        name="image" 
                                        accept="image/jpeg,image/png,image/jpg"
                                        required
                                    >
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

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('serviceForm');
            const imageInput = document.getElementById('image');
            const previewContainer = document.getElementById('imagePreview');
            const maxFileSize = 2 * 1024 * 1024; // 2MB

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
                const feedback = element.nextElementSibling.nextElementSibling;
                if (feedback) {
                    feedback.textContent = !isValid ? errorMessage : '';
                }
            };

            // Preview de l'image
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
                            <img src="${e.target.result}" class="img-thumbnail" alt="Aperçu de l'image">
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
                this.classList.remove('is-invalid');
            });

            // Validation du formulaire
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let isValid = true;

                // Validation des champs texte
                isValid = validateField(document.getElementById('name'), 1, 10) && isValid;
                isValid = validateField(document.getElementById('title'), 4, 20) && isValid;
                isValid = validateField(document.getElementById('description'), 1, 100) && isValid;

                // Validation du prix
                const price = document.getElementById('price');
                const priceValue = parseFloat(price.value);
                const isPriceValid = !isNaN(priceValue) && priceValue > 0;
                toggleError(price, isPriceValid, 'Le prix doit être supérieur à 0');
                isValid = isPriceValid && isValid;

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