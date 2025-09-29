// Enhanced JavaScript for Mobile Responsiveness
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navLinks = document.querySelectorAll('.nav-link');
    const darkModeToggle = document.getElementById('dark-mode-toggle-checkbox');

    // Navbar scroll effect
    function handleScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    }

    // Close mobile menu when clicking on a link
    function closeMobileMenu() {
        if (window.innerWidth < 992) {
            const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                toggle: false
            });
            bsCollapse.hide();
        }
    }

    // Smooth scrolling for anchor links
    function smoothScroll(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            const offsetTop = targetElement.getBoundingClientRect().top + window.pageYOffset - 80;

            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });

            // Update active link
            navLinks.forEach(link => link.classList.remove('active'));
            this.classList.add('active');

            // Close mobile menu after click
            setTimeout(closeMobileMenu, 300);
        }
    }

    // Handle resize events
    function handleResize() {
        if (window.innerWidth >= 992) {
            navbarCollapse.classList.remove('show');
        }
    }

    // Dark mode functionality
    function toggleDarkMode() {
        if (darkModeToggle.checked) {
            document.body.classList.add('dark-mode');
            // Add your dark mode styles here
        } else {
            document.body.classList.remove('dark-mode');
        }
    }

    // Event Listeners
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resize', handleResize);
    darkModeToggle.addEventListener('change', toggleDarkMode);

    // Add smooth scrolling to nav links
    navLinks.forEach(link => {
        if (link.getAttribute('href').startsWith('#')) {
            link.addEventListener('click', smoothScroll);
        }
    });

    // Close menu when clicking outside on mobile
    document.addEventListener('click', function (e) {
        if (window.innerWidth < 992 &&
            !navbar.contains(e.target) &&
            navbarCollapse.classList.contains('show')) {
            closeMobileMenu();
        }
    });

    // Keyboard navigation for accessibility
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
            closeMobileMenu();
            navbarToggler.focus();
        }
    });

    // Initialize
    handleScroll();
});

// Additional enhancement: Add loading state for buttons
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.navbar-buttons .btn');

    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            if (!this.href.includes('#')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            }
        });
    });
});
