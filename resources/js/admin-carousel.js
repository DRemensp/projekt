document.addEventListener('DOMContentLoaded', function() {
    const carousel = {
        currentSlide: 0,
        totalSlides: 5,
        slidesContainer: document.getElementById('carouselSlides'),
        dots: document.querySelectorAll('.dot'),
        prevBtn: document.getElementById('prevBtn'),
        nextBtn: document.getElementById('nextBtn'),
        slideIndicator: document.getElementById('slideIndicator'),

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


        updateCarousel() {
            // Move slides
            const translateX = -this.currentSlide * 20; // 20% per slide
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
});
