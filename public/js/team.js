document.addEventListener('DOMContentLoaded', function() {
    // Configuration du modal d'ajout de membre
    const addTeamMemberModal = new bootstrap.Modal(document.getElementById('addTeamMemberModal'));
    
    // Gestion du formulaire d'ajout
    const addTeamMemberForm = document.getElementById('addTeamMemberForm');
    if (addTeamMemberForm) {
        addTeamMemberForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('/team', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Afficher le message de succès
                    showAlert('success', 'Membre ajouté avec succès !');
                    
                    // Fermer le modal
                    addTeamMemberModal.hide();
                    
                    // Recharger la page après un court délai
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    // Afficher les erreurs
                    showAlert('error', data.message || 'Une erreur est survenue');
                }
            } catch (error) {
                showAlert('error', 'Une erreur est survenue lors de l\'ajout du membre');
            }
        });
    }

    // Prévisualisation de l'image
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Validation des champs en temps réel
    const inputs = document.querySelectorAll('#addTeamMemberForm input, #addTeamMemberForm select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            validateField(this);
        });
    });

    // Fonction de validation des champs
    function validateField(field) {
        const errorDiv = field.nextElementSibling;
        if (!field.value && field.hasAttribute('required')) {
            field.classList.add('is-invalid');
            if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                const div = document.createElement('div');
                div.classList.add('invalid-feedback');
                div.textContent = 'Ce champ est requis';
                field.parentNode.insertBefore(div, field.nextSibling);
            }
        } else {
            field.classList.remove('is-invalid');
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.remove();
            }
        }
    }

    // Fonction pour afficher les alertes
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.classList.add('alert', `alert-${type === 'success' ? 'success' : 'danger'}`, 'alert-dismissible', 'fade', 'show');
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const container = document.querySelector('.card-body');
        container.insertBefore(alertDiv, container.firstChild);

        // Supprimer l'alerte après 3 secondes
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Gestion de la réinitialisation du formulaire
    document.getElementById('addTeamMemberModal').addEventListener('hidden.bs.modal', function () {
        addTeamMemberForm.reset();
        if (imagePreview) {
            imagePreview.style.display = 'none';
            imagePreview.src = '';
        }
        // Supprimer tous les messages d'erreur
        document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });
});