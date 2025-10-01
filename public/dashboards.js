document.addEventListener('DOMContentLoaded', function() {
    // Toggle mobile menu
    const menuButton = document.createElement('button');
    menuButton.innerHTML = '<i class="fas fa-bars"></i>';
    menuButton.classList.add('mobile-menu-button');
    document.body.appendChild(menuButton);

    menuButton.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // Section navigation
    window.showSection = function(section) {
        // Hide all sections
        const sections = document.querySelectorAll('main.main-content > section');
        sections.forEach(s => s.style.display = 'none');

        // Show selected section
        const selectedSection = document.getElementById('section-' + section);
        if (selectedSection) {
            selectedSection.style.display = 'block';
        }

        // Update active menu item
        const menuItems = document.querySelectorAll('.nav-menu .nav-link');
        menuItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('onclick')?.includes(section)) {
                item.classList.add('active');
            }
        });
    }

    // Initialize first section
    showSection('dashboard');

    // Handle window resize
    function checkScreenSize() {
        const sidebar = document.querySelector('.sidebar');
        const menuButton = document.querySelector('.mobile-menu-button');

        if (window.innerWidth <= 1024) {
            menuButton.style.display = 'block';
        } else {
            menuButton.style.display = 'none';
            sidebar.classList.remove('active');
        }
    }

    window.addEventListener('resize', checkScreenSize);
    checkScreenSize();
});