// ===== SERVICE CREATE PAGE JAVASCRIPT - SIMPLIFIED =====

document.addEventListener('DOMContentLoaded', function() {
    // ===== DOM ELEMENTS CACHING =====
    const form = document.getElementById('serviceForm');
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreview');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');

    // ===== CONSTANTS =====
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
    const VALID_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/jpg'];

    // ===== UTILITY FUNCTIONS =====
    
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
});
