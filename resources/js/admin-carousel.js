// resources/js/admin-carousel.js
function initAdminCarousel() {
    const slidesContainer = document.getElementById('carouselSlides');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const slideIndicator = document.getElementById('slideIndicator');

    // Prüfen ob alle Elemente vorhanden sind
    if (!slidesContainer || !prevBtn || !nextBtn || !slideIndicator || dots.length === 0) {
        return; // Nicht auf dieser Seite vorhanden
    }

    // Prüfen ob bereits initialisiert
    if (slidesContainer.hasAttribute('data-carousel-initialized')) return;
    slidesContainer.setAttribute('data-carousel-initialized', 'true');

    const carousel = {
        currentSlide: 0,
        totalSlides: dots.length,
        slidesContainer: slidesContainer,
        dots: dots,
        prevBtn: prevBtn,
        nextBtn: nextBtn,
        slideIndicator: slideIndicator,
        touchStartX: 0,
        touchStartY: 0,
        touchEndX: 0,
        isDragging: false,

        init() {
            // Restore slide position from localStorage if available
            const savedSlide = localStorage.getItem('adminCarouselPosition');
            if (savedSlide !== null) {
                this.currentSlide = parseInt(savedSlide, 10);
            }

            this.bindEvents();
            this.updateCarousel();

            // Restore scroll position after a short delay to ensure carousel is fully rendered
            setTimeout(() => {
                const savedScrollPosition = localStorage.getItem('adminScrollPosition');
                if (savedScrollPosition !== null) {
                    window.scrollTo(0, parseInt(savedScrollPosition, 10));
                }
            }, 100);
        },

        bindEvents() {
            // Arrow buttons
            this.prevBtn.addEventListener('click', () => this.previousSlide());
            this.nextBtn.addEventListener('click', () => this.nextSlide());

            // Dot navigation
            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => this.goToSlide(index));
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') this.previousSlide();
                if (e.key === 'ArrowRight') this.nextSlide();
            });

            // Touch/Swipe Events für Mobile - VERBESSERT
            this.slidesContainer.addEventListener('touchstart', (e) => {
                this.touchStartX = e.changedTouches[0].screenX;
                this.touchStartY = e.changedTouches[0].screenY;
                this.isDragging = true;
            }, { passive: true });

            this.slidesContainer.addEventListener('touchmove', (e) => {
                if (!this.isDragging) return;

                const touchCurrentX = e.changedTouches[0].screenX;
                const touchCurrentY = e.changedTouches[0].screenY;

                const diffX = Math.abs(this.touchStartX - touchCurrentX);
                const diffY = Math.abs(this.touchStartY - touchCurrentY);

                // Nur horizontal swipe verhindern wenn die horizontale Bewegung
                // DEUTLICH größer ist als die vertikale Bewegung
                // UND es ist eine signifikante horizontale Bewegung (>30px)
                if (diffX > 30 && diffX > diffY * 2) {
                    e.preventDefault();
                }
            }, { passive: false });

            this.slidesContainer.addEventListener('touchend', (e) => {
                if (!this.isDragging) return;

                this.touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe();
                this.isDragging = false;
            }, { passive: true });
        },

        handleSwipe() {
            const swipeThreshold = 50; // Minimum distance for a swipe
            const swipeDistance = this.touchEndX - this.touchStartX;

            if (Math.abs(swipeDistance) < swipeThreshold) {
                return; // Not a significant swipe
            }

            if (swipeDistance > 0) {
                // Swipe right - go to previous slide
                this.previousSlide();
            } else {
                // Swipe left - go to next slide
                this.nextSlide();
            }
        },

        updateCarousel() {
            // Move slides - für 6 slides: 100% / 6 = 16.666667%
            const slideWidth = 100 / this.totalSlides;
            const translateX = -this.currentSlide * slideWidth;
            this.slidesContainer.style.transform = `translateX(${translateX}%)`;

            // Update active states for slides
            document.querySelectorAll('.carousel-slide').forEach((slide, index) => {
                if (index === this.currentSlide) {
                    slide.classList.remove('opacity-0');
                    slide.classList.add('opacity-100', 'active');
                } else {
                    slide.classList.remove('opacity-100', 'active');
                    slide.classList.add('opacity-0');
                }
            });

            // Update dots
            this.dots.forEach((dot, index) => {
                if (index === this.currentSlide) {
                    dot.classList.remove('bg-gray-400');
                    dot.classList.add('bg-indigo-600', 'scale-125', 'active');
                } else {
                    dot.classList.remove('bg-indigo-600', 'scale-125', 'active');
                    dot.classList.add('bg-gray-400');
                }
            });

            // Update navigation buttons
            this.prevBtn.disabled = this.currentSlide === 0;
            this.nextBtn.disabled = this.currentSlide === this.totalSlides - 1;

            // Update progress indicator
            this.slideIndicator.textContent = `${this.currentSlide + 1} von ${this.totalSlides}`;

            // Save current slide position and scroll position to localStorage
            localStorage.setItem('adminCarouselPosition', this.currentSlide);
            localStorage.setItem('adminScrollPosition', window.scrollY);
        },

        goToSlide(index) {
            if (index >= 0 && index < this.totalSlides) {
                this.currentSlide = index;
                this.updateCarousel();
            }
        },

        nextSlide() {
            if (this.currentSlide < this.totalSlides - 1) {
                this.currentSlide++;
                this.updateCarousel();
            }
        },

        previousSlide() {
            if (this.currentSlide > 0) {
                this.currentSlide--;
                this.updateCarousel();
            }
        }
    };

    carousel.init();
}

// Initialisierung nach DOM-Laden oder sofort wenn bereits geladen
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminCarousel);
} else {
    initAdminCarousel();
}
