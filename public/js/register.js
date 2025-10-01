document.addEventListener('DOMContentLoaded', function() {
    // Récupération des éléments
    const form = document.querySelector('form');
    const fileInput = document.getElementById('profile_picture');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    const submitButton = document.querySelector('.btn-submit');

    // Prévisualisation de l'image
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        let preview = document.querySelector('.image-preview');
                        if (!preview) {
                            preview = document.createElement('div');
                            preview.className = 'image-preview';
                            fileInput.parentNode.appendChild(preview);
                        }
                        preview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" style="max-width: 200px; border-radius: 0.5rem; margin-top: 1rem;">
                            <button type="button" class="remove-image" style="display: block; margin-top: 0.5rem; color: var(--danger-color);">
                                Supprimer l'image
                            </button>
                        `;

                        // Gestion de la suppression de l'image
                        preview.querySelector('.remove-image').onclick = function() {
                            fileInput.value = '';
                            preview.remove();
                        };
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Veuillez sélectionner une image valide');
                    fileInput.value = '';
                }
            }
        });
    }

    // Validation des mots de passe
    function validatePasswords() {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Les mots de passe ne correspondent pas');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    }

    if (password && passwordConfirm) {
        password.addEventListener('input', validatePasswords);
        passwordConfirm.addEventListener('input', validatePasswords);
    }

    // Animation du bouton lors de la soumission
    if (form) {
        form.addEventListener('submit', function(e) {
            if (form.checkValidity()) {
                submitButton.innerHTML = `
                    <span class="spinner"></span>
                    Création du compte...
                `;
                submitButton.disabled = true;
            }
        });
    }

    // Validation du numéro de téléphone
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Permet uniquement les chiffres et quelques caractères spéciaux
            let value = e.target.value.replace(/[^\d+\-\s()]/g, '');
            e.target.value = value;
        });
    }

    // Message de confirmation avant reset
    const resetButton = document.querySelector('.btn-reset');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ?')) {
                form.reset();
                const preview = document.querySelector('.image-preview');
                if (preview) preview.remove();
            }
        });
    }

    // Vérification de la force du mot de passe
    if (password) {
        password.addEventListener('input', function(e) {
            const value = e.target.value;
            let strength = 0;
            let message = '';
            let color = '';

            // Longueur minimum
            if (value.length >= 8) strength += 1;
            // Contient des chiffres
            if (/\d/.test(value)) strength += 1;
            // Contient des lettres minuscules et majuscules
            if (/[a-z]/.test(value) && /[A-Z]/.test(value)) strength += 1;
            // Contient des caractères spéciaux
            if (/[^A-Za-z0-9]/.test(value)) strength += 1;

            switch(strength) {
                case 0:
                    message = 'Très faible';
                    color = '#ef4444';
                    break;
                case 1:
                    message = 'Faible';
                    color = '#f97316';
                    break;
                case 2:
                    message = 'Moyen';
                    color = '#eab308';
                    break;
                case 3:
                    message = 'Fort';
                    color = '#22c55e';
                    break;
                case 4:
                    message = 'Très fort';
                    color = '#15803d';
                    break;
            }

            // Mise à jour de l'indicateur visuel
            const strengthMeter = document.createElement('div');
            strengthMeter.style.height = '4px';
            strengthMeter.style.width = `${(strength / 4) * 100}%`;
            strengthMeter.style.backgroundColor = color;
            strengthMeter.style.transition = 'all 0.3s ease';
            strengthMeter.style.borderRadius = '2px';

            const strengthText = document.createElement('p');
            strengthText.textContent = `Force du mot de passe : ${message}`;
            strengthText.style.color = color;
            strengthText.style.fontSize = '0.875rem';
            strengthText.style.marginTop = '0.5rem';

            const strengthIndicator = document.querySelector('.strength-indicator');
            if (!strengthIndicator) {
                const div = document.createElement('div');
                div.className = 'strength-indicator';
                div.style.marginTop = '0.5rem';
                password.parentNode.appendChild(div);
            }

            const indicator = document.querySelector('.strength-indicator');
            indicator.innerHTML = '';
            indicator.appendChild(strengthMeter);
            indicator.appendChild(strengthText);
        });
    }
});