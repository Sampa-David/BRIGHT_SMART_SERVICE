document.addEventListener('DOMContentLoaded', function() {
    // Toggle mobile menu
    const menuButton = document.createElement('button');
    menuButton.innerHTML = '<i class="bi bi-list"></i>';
    menuButton.classList.add('mobile-menu-button');
    document.body.appendChild(menuButton);
    
    menuButton.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // Responsive behavior
    function checkScreenSize() {
        if (window.innerWidth <= 1024) {
            menuButton.style.display = 'block';
        } else {
            menuButton.style.display = 'none';
            document.querySelector('.sidebar').classList.remove('active');
        }
    }

    window.addEventListener('resize', checkScreenSize);
    checkScreenSize();

    // Section navigation
    window.showSection = function(section) {
        // Hide all sections
        document.querySelectorAll('main.main-content > section').forEach(section => {
            section.style.display = 'none';
        });

        // Show selected section
        const selectedSection = document.getElementById('section-' + section);
        if (selectedSection) {
            selectedSection.style.display = 'block';
            
            // Animate appearance
            selectedSection.style.opacity = '0';
            selectedSection.style.transform = 'translateY(20px)';
            
            requestAnimationFrame(() => {
                selectedSection.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                selectedSection.style.opacity = '1';
                selectedSection.style.transform = 'translateY(0)';
            });
        }

        // Update active menu item
        document.querySelectorAll('.nav-item a').forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('onclick')?.includes(section)) {
                link.classList.add('active');
            }
        });

        // Close mobile menu after selection
        if (window.innerWidth <= 1024) {
            document.querySelector('.sidebar').classList.remove('active');
        }

        // Update URL without reload
        const url = new URL(window.location);
        url.searchParams.set('section', section);
        window.history.pushState({}, '', url);
    }

    // Section navigation
    window.showSection = function(section) {
        // Masquer toutes les sections
        const allSections = document.querySelectorAll('main.main-content > section');
        allSections.forEach(section => section.style.display = 'none');

        // Afficher la section sélectionnée
        const selectedSection = document.getElementById('section-' + section);
        if (selectedSection) {
            selectedSection.style.display = 'block';
            
            // Animer l'apparition
            selectedSection.style.opacity = '0';
            selectedSection.style.transform = 'translateY(20px)';
            
            requestAnimationFrame(() => {
                selectedSection.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                selectedSection.style.opacity = '1';
                selectedSection.style.transform = 'translateY(0)';
            });
        }

        // Mettre à jour les liens actifs
        const menuLinks = document.querySelectorAll('.nav-menu .nav-link');
        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('onclick')?.includes(section)) {
                link.classList.add('active');
            }
        });

        // Fermer le menu mobile après la sélection
        if (window.innerWidth <= 1024) {
            document.querySelector('.sidebar').classList.remove('active');
        }

        // Mettre à jour l'URL sans recharger la page
        const url = new URL(window.location);
        url.searchParams.set('section', section);
        window.history.pushState({}, '', url);
    }

    // Gérer le bouton retour du navigateur
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section') || 'dashboard';
        showSection(section);
    });

    // Initialiser la première section
    const urlParams = new URLSearchParams(window.location.search);
    const initialSection = urlParams.get('section') || 'dashboard';
    showSection(initialSection);

    // Gestion de l'édition des membres de l'équipe
    document.querySelectorAll('.edit-member').forEach(button => {
        button.addEventListener('click', function() {
            const memberId = this.dataset.memberId;
            const row = this.closest('tr');

            // Remplir le formulaire avec les données du membre
            document.getElementById('edit_name').value = row.querySelector('td:nth-child(2)').textContent;
            document.getElementById('edit_role').value = row.querySelector('td:nth-child(3)').textContent;
            document.getElementById('edit_department_id').value = row.querySelector('td:nth-child(4)').dataset.departmentId;
            document.getElementById('edit_email').value = row.querySelector('td:nth-child(5)').textContent;

            // Mettre à jour l'URL du formulaire
            const form = document.getElementById('editTeamMemberForm');
            form.action = `/team/${memberId}`;
        });
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const menuButton = document.querySelector('.mobile-menu-button');
        
        if (!sidebar.contains(event.target) && !menuButton.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    });
});