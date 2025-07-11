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
    mobileMenuButton.addEventListener('click', (e) => {
        e.stopPropagation(); // Verhindert, dass der Click-Event nach oben bubbled
        toggleMobileMenu();
    });

    // Schließen bei Klick außerhalb des Menüs
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
            closeMobileMenu();
        }
    });

    // Schließen bei Escape-Taste
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });

    // Schließen bei Resize (wenn auf Desktop gewechselt wird)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) { // lg breakpoint
            closeMobileMenu();
        }
    });

    function toggleMobileMenu() {
        const isHidden = mobileMenu.classList.contains('hidden');

        if (isHidden) {
            openMobileMenu();
        } else {
            closeMobileMenu();
        }
    }

    function openMobileMenu() {
        // Entfernen der hidden-Klasse
        mobileMenu.classList.remove('hidden');

        // Setze initial height auf 0 für Animation
        mobileMenu.style.height = '0px';
        mobileMenu.style.overflow = 'hidden';

        // Erzwinge Reflow
        mobileMenu.offsetHeight;

        // Berechne die volle Höhe
        const fullHeight = mobileMenu.scrollHeight;

        // Starte Animation
        mobileMenu.style.transition = 'height 0.3s ease-out';
        mobileMenu.style.height = fullHeight + 'px';

        // Nach Animation cleanup
        setTimeout(() => {
            mobileMenu.style.height = 'auto';
            mobileMenu.style.overflow = 'visible';
        }, 300);
    }

    function closeMobileMenu() {
        if (mobileMenu.classList.contains('hidden')) return;

        // Aktuelle Höhe festlegen
        const currentHeight = mobileMenu.offsetHeight;
        mobileMenu.style.height = currentHeight + 'px';
        mobileMenu.style.overflow = 'hidden';

        // Erzwinge Reflow
        mobileMenu.offsetHeight;

        // Starte Animation zum Schließen
        mobileMenu.style.transition = 'height 0.3s ease-in';
        mobileMenu.style.height = '0px';

        // Nach Animation verstecken
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
            mobileMenu.style.height = '';
            mobileMenu.style.overflow = '';
            mobileMenu.style.transition = '';
        }, 300);
    }
}

// Initialisierung nach DOM-Laden oder sofort wenn bereits geladen
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNavbar);
} else {
    initNavbar();
}
