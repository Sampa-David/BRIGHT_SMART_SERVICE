// ===== SERVICE CREATE PAGE JAVASCRIPT - IMPROVED =====

document.addEventListener('DOMContentLoaded', function() {
    // ===== DOM ELEMENTS CACHING =====
    const form = document.getElementById('serviceForm');
    const imageInput = document.getElementById('image');
    const imagePickerBtn = document.getElementById('imagePickerBtn');
    const previewContainer = document.getElementById('imagePreview');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');

    // Modal elements
    const imagePickerModalElement = document.getElementById('imagePickerModal');
    const modal = new bootstrap.Modal(imagePickerModalElement, {
        keyboard: false,
        backdrop: 'static'
    });
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

    // ===== CONSTANTS =====
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
    // Utilise Pixabay comme alternative (API libre sans authentification complexe)
    const PIXABAY_API_KEY = '47340408-fa7adf893d0ccc108f99b0fbc';
    const VALID_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/jpg'];

    // ===== MODAL STATE MANAGEMENT =====
    const modalState = {
        selectedImageUrl: null,
        serviceName: '',
        isSearching: false,
        currentMode: 'options' // 'options' | 'web-search'
    };

    // ===== UTILITY FUNCTIONS =====
    
    /**
     * Show/hide element with animation
     */
    const toggleVisibility = (element, show, animated = true) => {
        if (show) {
            element.classList.remove('hidden');
            if (animated) {
                element.style.opacity = '0';
                setTimeout(() => {
                    element.style.transition = 'opacity 0.3s ease-out';
                    element.style.opacity = '1';
                }, 10);
            }
        } else {
            if (animated) {
                element.style.transition = 'opacity 0.2s ease-out';
                element.style.opacity = '0';
                setTimeout(() => {
                    element.classList.add('hidden');
                    element.style.opacity = '';
                    element.style.transition = '';
                }, 200);
            } else {
                element.classList.add('hidden');
            }
        }
    };

    /**
     * Toggle error state on form element
     */
    const toggleError = (element, isValid, errorMessage = '') => {
        if (isValid) {
            element.classList.remove('is-invalid');
            const feedback = element.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = '';
            }
        } else {
            element.classList.add('is-invalid');
            const feedback = element.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = errorMessage;
            }
        }
    };

    /**
     * Validate field length
     */
    const validateField = (input, min, max) => {
        const value = input.value.trim();
        const isValid = value.length >= min && value.length <= max;
        toggleError(input, isValid, `Le champ doit contenir entre ${min} et ${max} caractères`);
        return isValid;
    };

    /**
     * Reset modal to initial state
     */
    const resetModal = () => {
        // Clear state
        modalState.selectedImageUrl = null;
        modalState.isSearching = false;
        modalState.currentMode = 'options';

        // Clear UI
        imageGallery.innerHTML = '';
        searchInput.value = '';
        confirmImageBtn.disabled = true;
        confirmImageBtn.innerHTML = 'Confirmer l\'image';

        // Show options, hide web search
        toggleVisibility(imagePickerOptions, true, false);
        toggleVisibility(webSearchContainer, false, false);
        webSearchContainer.classList.remove('show');
    };

    /**
     * Switch modal mode
     */
    const switchModalMode = (mode) => {
        const isWebMode = mode === 'web-search';
        
        if (isWebMode) {
            toggleVisibility(imagePickerOptions, false, true);
            toggleVisibility(webSearchContainer, true, true);
            webSearchContainer.classList.add('show');
            setTimeout(() => searchInput.focus(), 300);
        } else {
            webSearchContainer.classList.remove('show');
            toggleVisibility(webSearchContainer, false, true);
            toggleVisibility(imagePickerOptions, true, true);
        }
        
        modalState.currentMode = mode;
    };

    // ===== IMAGE PICKER MODAL HANDLERS =====

    /**
     * Open image picker modal
     */
    imagePickerBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        modalState.serviceName = nameInput.value.trim() || 'service';
        searchInput.value = modalState.serviceName;
        resetModal();
        modal.show();
    });

    /**
     * Local storage button click - open file dialog
     */
    localStorageBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        imageInput.click();
    });

    /**
     * Web search button click - switch to web search mode
     */
    webSearchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        switchModalMode('web-search');
    });

    /**
     * Back button click - switch back to options
     */
    backBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        switchModalMode('options');
        // Clear gallery when going back
        imageGallery.innerHTML = '';
        imageGallery.classList.add('hidden');
        noResults.classList.add('hidden');
        modalState.selectedImageUrl = null;
        confirmImageBtn.disabled = true;
        confirmImageBtn.classList.add('hidden');
    });

    // ===== IMAGE SEARCH HANDLERS =====

    /**
     * Search images from Pixabay API
     */
    const searchImages = async (query) => {
        query = query.trim();
        
        if (!query) {
            toggleVisibility(imageGalleryContainer, false);
            toggleVisibility(imageGallery, false);
            toggleVisibility(noResults, true);
            noResults.textContent = 'Veuillez entrer un terme de recherche';
            return;
        }

        if (modalState.isSearching) return;

        modalState.isSearching = true;
        searchBtn.disabled = true;
        searchInput.disabled = true;

        // Show loading spinner
        toggleVisibility(imageGalleryContainer, true);
        toggleVisibility(imageGallery, false);
        toggleVisibility(noResults, false);

        try {
            const url = `https://pixabay.com/api/?key=${PIXABAY_API_KEY}&q=${encodeURIComponent(query)}&image_type=photo&per_page=12&orientation=horizontal`;
            
            console.log('Searching for:', query);
            console.log('API URL:', url);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                console.error('API Error:', errorData);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('API Response:', data);

            // Hide loading spinner
            toggleVisibility(imageGalleryContainer, false);

            if (data.hits && data.hits.length > 0) {
                displayPixabayImages(data.hits);
                toggleVisibility(imageGallery, true);
                toggleVisibility(noResults, false);
            } else {
                toggleVisibility(imageGallery, false);
                toggleVisibility(noResults, true);
                noResults.textContent = 'Aucune image trouvée pour cette recherche';
            }
        } catch (error) {
            console.error('Search error:', error);
            console.error('Error message:', error.message);
            toggleVisibility(imageGalleryContainer, false);
            toggleVisibility(imageGallery, false);
            toggleVisibility(noResults, true);
            noResults.textContent = 'Erreur lors de la recherche. Veuillez réessayer.';
        } finally {
            modalState.isSearching = false;
            searchBtn.disabled = false;
            searchInput.disabled = false;
        }
    };

    /**
     * Display Pixabay images in gallery
     */
    const displayPixabayImages = (images) => {
        imageGallery.innerHTML = '';
        
        images.forEach((image, index) => {
            const item = document.createElement('div');
            item.className = 'image-gallery-item';
            
            const img = document.createElement('img');
            img.src = image.previewURL;
            img.alt = image.tags || `Image ${index + 1}`;
            img.loading = 'lazy';
            
            item.appendChild(img);
            
            // Click event with proper event delegation
            item.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Deselect previous image
                imageGallery.querySelectorAll('.image-gallery-item.selected').forEach(el => {
                    el.classList.remove('selected');
                });
                
                // Select new image
                item.classList.add('selected');
                modalState.selectedImageUrl = image.largeImageURL;
                
                // Show confirm button
                confirmImageBtn.disabled = false;
                confirmImageBtn.classList.remove('hidden');
            });
            
            imageGallery.appendChild(item);
        });
    };

    /**
     * Search button click handler
     */
    searchBtn.addEventListener('click', (e) => {
        e.preventDefault();
        searchImages(searchInput.value);
    });

    /**
     * Enter key in search input
     */
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchImages(searchInput.value);
        }
    });

    /**
     * Confirm selected web image
     */
    confirmImageBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        if (!modalState.selectedImageUrl) {
            console.warn('No image selected');
            return;
        }

        confirmImageBtn.disabled = true;
        const originalText = confirmImageBtn.innerHTML;
        confirmImageBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Téléchargement...';

        try {
            // Download image from URL
            const response = await fetch(modalState.selectedImageUrl);
            
            if (!response.ok) {
                throw new Error(`Download failed with status ${response.status}`);
            }

            const blob = await response.blob();

            // Create File from blob
            const urlParts = modalState.selectedImageUrl.split('/');
            const filename = (urlParts[urlParts.length - 1] || 'image').split('?')[0] || 'service-image.jpg';
            const ext = filename.includes('.') ? '' : '.jpg';
            const finalFilename = filename + ext;

            const file = new File([blob], finalFilename, { type: blob.type || 'image/jpeg' });

            // Assign file to input via DataTransfer
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInput.files = dataTransfer.files;

            // Trigger change event to update preview
            imageInput.dispatchEvent(new Event('change', { bubbles: true }));

            // Close modal
            modal.hide();

            // Reset modal state
            resetModal();

        } catch (error) {
            console.error('Download error:', error);
            confirmImageBtn.disabled = false;
            confirmImageBtn.innerHTML = originalText;
            
            // Show error message
            noResults.classList.remove('hidden');
            noResults.textContent = 'Erreur lors du téléchargement de l\'image. Veuillez réessayer.';
        }
    });

    // ===== IMAGE INPUT CHANGE HANDLER =====

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (!file) {
            previewContainer.innerHTML = '';
            return;
        }

        // Validate file type
        if (!VALID_IMAGE_TYPES.includes(file.type)) {
            toggleError(this, false, 'Le format du fichier doit être JPG, JPEG ou PNG');
            this.value = '';
            previewContainer.innerHTML = '';
            return;
        }

        // Validate file size
        if (file.size > MAX_FILE_SIZE) {
            toggleError(this, false, 'L\'image ne doit pas dépasser 2MB');
            this.value = '';
            previewContainer.innerHTML = '';
            return;
        }

        // Clear previous errors
        toggleError(this, true);

        // Display preview with animation
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = `
                <div class="preview-wrapper">
                    <img src="${e.target.result}" alt="Aperçu de l'image" loading="lazy">
                </div>
            `;
        };
        reader.readAsDataURL(file);

        // Reset modal variables when new image is selected
        modalState.selectedImageUrl = null;
        imageGallery.innerHTML = '';
    });

    // ===== NAME INPUT CHANGE HANDLER =====

    nameInput.addEventListener('change', function() {
        modalState.serviceName = this.value.trim() || 'service';
    });

    nameInput.addEventListener('input', function() {
        modalState.serviceName = this.value.trim() || 'service';
    });

    // ===== FORM SUBMISSION =====

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;

        // Validate name (1-10 characters)
        isValid = validateField(nameInput, 1, 10) && isValid;

        // Validate description (must not be empty)
        const descValue = descriptionInput.value.trim();
        const isDescValid = descValue.length > 0;
        toggleError(descriptionInput, isDescValid, 'La description est requise');
        isValid = isDescValid && isValid;

        // Validate image (must have a file)
        const hasImage = imageInput.files && imageInput.files[0];
        const isImageValid = !!hasImage;
        toggleError(imageInput, isImageValid, 'Une image est requise');
        isValid = isImageValid && isValid;

        if (!isValid) {
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // Submit form with loading state
        const submitBtn = this.querySelector('[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';

        // Add small delay to show loading state
        setTimeout(() => {
            form.submit();
        }, 300);
    });

    // ===== MODAL EVENT LISTENERS FOR CLEANUP =====

    imagePickerModalElement.addEventListener('hide.bs.modal', function() {
        // Reset modal state when hiding
        resetModal();
        // Stop any ongoing search
        modalState.isSearching = false;
    });

    imagePickerModalElement.addEventListener('show.bs.modal', function() {
        // Ensure modal is in clean state when showing
        resetModal();
    });

    // Prevent scroll when modal is open
    imagePickerModalElement.addEventListener('show.bs.modal', function() {
        document.body.style.overflow = 'hidden';
    });

    imagePickerModalElement.addEventListener('hidden.bs.modal', function() {
        document.body.style.overflow = '';
    });
});
