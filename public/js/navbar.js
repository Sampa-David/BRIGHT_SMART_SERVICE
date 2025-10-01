/**
 * Navbar & Mobile Navigation Scripts
 */
document.addEventListener('DOMContentLoaded', () => {
    "use strict";

    /**
     * Mobile nav toggle
     */
    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const navbar = document.querySelector('#navbar');

    mobileNavToggle.addEventListener('click', function(e) {
        navbar.classList.toggle('mobile-nav-active');
        this.classList.toggle('bi-list');
        this.classList.toggle('bi-x');
    });

    /**
     * Hide mobile nav on same-page/hash links
     */
    document.querySelectorAll('#navbar a').forEach(navbarlink => {
        navbarlink.addEventListener('click', () => {
            if (navbar.classList.contains('mobile-nav-active')) {
                mobileNavToggle.click();
            }
        });
    });

    /**
     * Toggle .header-scrolled class to header when page is scrolled
     */
    const selectHeader = document.querySelector('#header');
    if (selectHeader) {
        document.addEventListener('scroll', () => {
            window.scrollY > 100 
                ? selectHeader.classList.add('sticked')
                : selectHeader.classList.remove('sticked');
        });
    }

    /**
     * Scroll to an element with header offset
     */
    const scrollto = (el) => {
        const header = document.querySelector('#header');
        const offset = header.offsetHeight;

        const elementPos = document.querySelector(el).offsetTop;
        window.scrollTo({
            top: elementPos - offset,
            behavior: 'smooth'
        });
    };

    /**
     * Scroll with offset on page load with hash links in the url
     */
    window.addEventListener('load', () => {
        if (window.location.hash) {
            if (document.querySelector(window.location.hash)) {
                scrollto(window.location.hash);
            }
        }
    });
});