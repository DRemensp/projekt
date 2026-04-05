// resources/js/navbar.js
function initNavbar() {
    const navbar = document.getElementById('navbar');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const brandLink = document.getElementById('mobileBrandLink');
    const brandLogoWrap = document.getElementById('mobileBrandLogoWrap');
    const brandText = document.getElementById('mobileBrandText');

    if (!navbar || !mobileMenuButton || !mobileMenu) return;

    // Prevent duplicate listeners.
    if (mobileMenuButton.hasAttribute('data-navbar-initialized')) return;
    mobileMenuButton.setAttribute('data-navbar-initialized', 'true');

    let mobileHeaderCollapsed = false;

    function isMobileViewport() {
        return window.matchMedia('(max-width: 767px)').matches;
    }

    function setHeaderExpanded() {
        if (!brandText || !brandLogoWrap || !brandLink) return;
        mobileHeaderCollapsed = false;
        brandText.style.transition = 'transform 500ms ease, opacity 400ms ease, margin 400ms ease, font-size 400ms ease';
        brandText.style.transform = 'translateX(0)';
        brandText.style.opacity = '1';
        brandText.style.marginLeft = '';
        brandText.style.fontSize = '';
        brandText.style.lineHeight = '';

        brandLogoWrap.style.transition = 'opacity 400ms ease, transform 500ms ease, width 400ms ease, height 400ms ease';
        brandLogoWrap.style.opacity = '1';
        brandLogoWrap.style.transform = 'scale(1)';
        brandLogoWrap.style.width = '';
        brandLogoWrap.style.height = '';

        // border-radius sofort entfernen, Rest animieren
        brandLink.style.transition = 'none';
        brandLink.style.borderRadius = '';
        brandLink.offsetHeight; // reflow
        brandLink.style.transition = 'padding 500ms ease, background-color 400ms ease, backdrop-filter 400ms ease, box-shadow 500ms ease, border-color 400ms ease';
        brandLink.style.pointerEvents = '';
        brandLink.style.padding = '';
        brandLink.style.gap = '';
        brandLink.style.transform = '';
        brandLink.style.position = '';
        brandLink.style.left = '';
        brandLink.style.top = '';
        brandLink.style.zIndex = '';
        brandLink.style.backgroundColor = '';
        brandLink.style.backdropFilter = '';
        brandLink.style.boxShadow = '';
        brandLink.style.border = '';
    }

    function setHeaderCollapsed() {
        if (!brandText || !brandLogoWrap || !brandLink) return;
        const darkMode = document.documentElement.classList.contains('dark');
        mobileHeaderCollapsed = true;

        brandText.style.transition = 'transform 500ms ease, opacity 400ms ease, margin 400ms ease, font-size 400ms ease';
        brandText.style.transform = 'translateX(0)';
        brandText.style.opacity = '1';
        brandText.style.marginLeft = '';
        brandText.style.fontSize = '0.95rem';
        brandText.style.lineHeight = '1';

        brandLogoWrap.style.transition = 'opacity 400ms ease, transform 500ms ease, width 400ms ease, height 400ms ease';
        brandLogoWrap.style.opacity = '1';
        brandLogoWrap.style.transform = 'scale(1)';
        brandLogoWrap.style.width = '2.25rem';
        brandLogoWrap.style.height = '2.25rem';

        // Aktuelle Bildschirmposition merken bevor position:fixed gesetzt wird
        const rect = brandLink.getBoundingClientRect();

        // border-radius + position sofort setzen (kein weißes Rechteck, kein Positionssprung)
        brandLink.style.transition = 'none';
        brandLink.style.borderRadius = '9999px';
        brandLink.style.position = 'fixed';
        brandLink.style.left = rect.left + 'px';
        brandLink.style.top = rect.top + 'px';
        brandLink.style.zIndex = '60';
        brandLink.offsetHeight; // reflow

        // Jetzt alles animieren inkl. Bewegung zur Zielposition
        brandLink.style.transition = 'left 500ms ease, top 500ms ease, padding 500ms ease, background-color 400ms ease, backdrop-filter 400ms ease, box-shadow 500ms ease, border-color 400ms ease';
        brandLink.style.pointerEvents = '';
        brandLink.style.left = '0.5rem';
        brandLink.style.top = '0.5rem';
        brandLink.style.padding = '0.34rem 0.5rem 0.34rem 0.34rem';
        brandLink.style.gap = '0.45rem';
        brandLink.style.transform = '';
        brandLink.style.backgroundColor = darkMode ? 'rgba(15, 23, 42, 0.5)' : 'rgba(255, 255, 255, 0.42)';
        brandLink.style.backdropFilter = 'blur(12px)';
        brandLink.style.boxShadow = darkMode ? '0 8px 24px rgba(2, 6, 23, 0.42)' : '0 8px 24px rgba(15, 23, 42, 0.22)';
        brandLink.style.border = darkMode ? '1px solid rgba(148, 163, 184, 0.35)' : '1px solid rgba(255, 255, 255, 0.5)';
    }

    function updateMobileBrandOnScroll() {
        const currentY = window.scrollY || 0;

        if (!isMobileViewport()) {
            if (mobileHeaderCollapsed) setHeaderExpanded();
            return;
        }

        if (currentY <= 8) {
            if (mobileHeaderCollapsed) setHeaderExpanded();
            return;
        }

        if (!mobileHeaderCollapsed) {
            setHeaderCollapsed();
        }
    }

    function toggleMobileMenu() {
        const isHidden = mobileMenu.classList.contains('hidden');
        if (isHidden) {
            openMobileMenu();
        } else {
            closeMobileMenu();
        }
    }

    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        mobileMenu.style.height = '0px';
        mobileMenu.style.overflow = 'hidden';
        mobileMenu.offsetHeight;

        const fullHeight = mobileMenu.scrollHeight;
        mobileMenu.style.transition = 'height 0.3s ease-out';
        mobileMenu.style.height = fullHeight + 'px';

        setTimeout(() => {
            mobileMenu.style.height = 'auto';
            mobileMenu.style.overflow = 'visible';
        }, 300);
    }

    function closeMobileMenu() {
        if (mobileMenu.classList.contains('hidden')) return;

        const currentHeight = mobileMenu.offsetHeight;
        mobileMenu.style.height = currentHeight + 'px';
        mobileMenu.style.overflow = 'hidden';
        mobileMenu.offsetHeight;

        mobileMenu.style.transition = 'height 0.3s ease-in';
        mobileMenu.style.height = '0px';

        setTimeout(() => {
            mobileMenu.classList.add('hidden');
            mobileMenu.style.height = '';
            mobileMenu.style.overflow = '';
            mobileMenu.style.transition = '';
        }, 300);
    }

    mobileMenuButton.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileMenu();
    });

    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
            closeMobileMenu();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });

    window.addEventListener('resize', () => {
        // xl breakpoint: desktop top nav is shown, dropdown must be closed.
        if (window.innerWidth >= 1280) {
            closeMobileMenu();
        }
        updateMobileBrandOnScroll();
    });

    window.addEventListener('scroll', updateMobileBrandOnScroll, { passive: true });
    updateMobileBrandOnScroll();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNavbar);
} else {
    initNavbar();
}
