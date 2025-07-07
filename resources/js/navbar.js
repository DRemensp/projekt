// resources/js/navbar.js
function initNavbar() {
    const navbar            = document.getElementById('navbar');
    const mobileMenuButton  = document.getElementById('mobileMenuButton');
    const mobileMenu        = document.getElementById('mobileMenu');

    if (!navbar || !mobileMenuButton || !mobileMenu) return;   // Sicherheitsnetz

    // Prüfen ob bereits initialisiert (verhindert doppelte Event Listener)
    if (mobileMenuButton.hasAttribute('data-navbar-initialized')) return;
    mobileMenuButton.setAttribute('data-navbar-initialized', 'true');

    // Burger-Button
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}

// Initialisierung nach DOM-Laden oder sofort wenn bereits geladen
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNavbar);
} else {
    initNavbar();
}
