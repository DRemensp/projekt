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
        brandText.style.transition = 'transform 280ms ease, opacity 220ms ease, margin 220ms ease, font-size 220ms ease';
        brandText.style.transform = 'translateX(0)';
        brandText.style.opacity = '1';
        brandText.style.marginLeft = '';
        brandText.style.fontSize = '';
        brandText.style.lineHeight = '';

        brandLogoWrap.style.transition = 'opacity 260ms ease, transform 280ms ease, width 260ms ease, height 260ms ease';
        brandLogoWrap.style.opacity = '1';
        brandLogoWrap.style.transform = 'scale(1)';
        brandLogoWrap.style.width = '';
        brandLogoWrap.style.height = '';

        brandLink.style.pointerEvents = '';
        brandLink.style.transition = 'padding 260ms ease, border-radius 260ms ease, background-color 260ms ease, backdrop-filter 260ms ease, box-shadow 260ms ease, border-color 260ms ease';
        brandLink.style.padding = '';
        brandLink.style.gap = '';
        brandLink.style.transform = '';
        brandLink.style.position = '';
        brandLink.style.left = '';
        brandLink.style.top = '';
        brandLink.style.zIndex = '';
        brandLink.style.borderRadius = '';
        brandLink.style.backgroundColor = '';
        brandLink.style.backdropFilter = '';
        brandLink.style.boxShadow = '';
        brandLink.style.border = '';
    }

    function setHeaderCollapsed() {
        if (!brandText || !brandLogoWrap || !brandLink) return;
        const darkMode = document.documentElement.classList.contains('dark');
        mobileHeaderCollapsed = true;
        brandText.style.transition = 'transform 280ms ease, opacity 220ms ease, margin 220ms ease, font-size 220ms ease';
        brandText.style.transform = 'translateX(0)';
        brandText.style.opacity = '1';
        brandText.style.marginLeft = '';
        brandText.style.fontSize = '0.95rem';
        brandText.style.lineHeight = '1';

        brandLogoWrap.style.transition = 'opacity 260ms ease, transform 280ms ease, width 260ms ease, height 260ms ease';
        brandLogoWrap.style.opacity = '1';
        brandLogoWrap.style.transform = 'scale(1)';
        brandLogoWrap.style.width = '2.25rem';
        brandLogoWrap.style.height = '2.25rem';

        // Keep the brand interactive and always visible in compact mode.
        brandLink.style.pointerEvents = '';
        brandLink.style.transition = 'padding 260ms ease, border-radius 260ms ease, background-color 260ms ease, backdrop-filter 260ms ease, box-shadow 260ms ease, border-color 260ms ease';
        brandLink.style.padding = '0.34rem 0.5rem 0.34rem 0.34rem';
        brandLink.style.gap = '0.45rem';
        brandLink.style.transform = '';
        brandLink.style.position = 'fixed';
        brandLink.style.left = '0.5rem';
        brandLink.style.top = '0.5rem';
        brandLink.style.zIndex = '60';
        brandLink.style.borderRadius = '9999px';
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
