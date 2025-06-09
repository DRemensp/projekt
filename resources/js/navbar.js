// resources/js/navbar.js
function initNavbar() {
    const navbar            = document.getElementById('navbar');
    const mobileMenuButton  = document.getElementById('mobileMenuButton');
    const mobileMenu        = document.getElementById('mobileMenu');

    if (!navbar || !mobileMenuButton || !mobileMenu) return;   // Sicherheitsnetz

    // Burger-Button
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}

//notwendig da durch redirect logik DOM schneller als Navbar.js geladen wird
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNavbar);
} else {
    initNavbar();
}
