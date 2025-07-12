// Slider functionality
(function() {
    const sliderTrack = document.querySelector('.slider-track');
    const slides = document.querySelectorAll('.resource-card');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    const dots = document.querySelectorAll('.dot');
    let currentSlide = 0;
    function updateSlider() {
        sliderTrack.style.transform = `translateX(-${currentSlide * 336}px)`;
        dots.forEach((dot, idx) => dot.classList.toggle('active', idx === currentSlide));
    }
    if (nextBtn && prevBtn && slides.length > 0) {
        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            updateSlider();
        });
        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            updateSlider();
        });
        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                currentSlide = idx;
                updateSlider();
            });
        });
        updateSlider();
    }
})();
// FAQ expand/collapse for Career Resources page
(function() {
    const faqCards = document.querySelectorAll('.cr-faq-card');
    faqCards.forEach(card => {
        const question = card.querySelector('.cr-faq-question');
        question.addEventListener('click', () => {
            const isActive = card.classList.contains('active');
            faqCards.forEach(c => c.classList.remove('active'));
            if (!isActive) card.classList.add('active');
        });
    });
})();
// Scroll-triggered animations
(function() {
    function animateOnScroll() {
        const animEls = document.querySelectorAll('.anim-fade-up, .anim-fade-down, .anim-fade-left, .anim-fade-right, .anim-zoom-in, .anim-flip');
        animEls.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 50) {
                el.classList.add('anim-visible');
            }
        });
    }
    window.addEventListener('scroll', animateOnScroll);
    window.addEventListener('load', animateOnScroll);
})(); 