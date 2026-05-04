// Updated scroll listener with RAF-ticking version
let ticking = false;
window.addEventListener('scroll', () => {
    if (!ticking) {
        requestAnimationFrame(() => {
            updateMobileBrandOnScroll();
            ticking = false;
        });
        ticking = true;
    }
}, { passive: true });

// Set header collapsed function with transform-based animation
brandLink.style.transition = 'transform 500ms ease, padding 500ms ease, background-color 400ms ease, backdrop-filter 400ms ease, box-shadow 500ms ease, border-color 400ms ease';
brandLink.style.pointerEvents = '';
brandLink.style.transform = `translate(calc(0.5rem - ${rect.left}px), calc(0.5rem - ${rect.top}px))`;