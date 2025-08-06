document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.slider');
    if (!slider) return;
    
    const container = slider.querySelector('.slides-container');
    const slides = Array.from(slider.querySelectorAll('.slide'));
    const prevBtn = slider.querySelector('.slider-prev');
    const nextBtn = slider.querySelector('.slider-next');
    const dots = Array.from(slider.querySelectorAll('.slider-dot'));
    
    if (slides.length === 0 || !container || !prevBtn || !nextBtn) return;
    
    let currentIndex = 0;
    let intervalId;
    const SLIDE_INTERVAL = 5000; // Уменьшил интервал до 5 сек (было 10)
    const TRANSITION_DURATION = 300; // Добавил константу для длительности анимации

    function initSlider() {
        slides[currentIndex].classList.add('active');
        updateDots();
        startAutoPlay();

        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });

        slider.addEventListener('mouseenter', stopAutoPlay);
        slider.addEventListener('mouseleave', startAutoPlay);
        slider.addEventListener('touchstart', stopAutoPlay, {passive: true});
        slider.addEventListener('touchend', startAutoPlay, {passive: true});
    }

    function goToSlide(index) {
        if (index === currentIndex || index < 0 || index >= slides.length) return;
        
        const direction = index > currentIndex ? 'next' : 'prev';
        const newIndex = index;
        
        slides[newIndex].classList.add(direction);
        void slides[newIndex].offsetWidth; 
        
        slides[currentIndex].classList.add(direction);
        
        setTimeout(() => {
            slides[currentIndex].classList.remove('active', 'next', 'prev');
            slides[newIndex].classList.remove('next', 'prev');
            slides[newIndex].classList.add('active');
            
            currentIndex = newIndex;
            updateDots();
        }, TRANSITION_DURATION);
        
        resetAutoPlay();
    }

    function nextSlide() {
        const newIndex = (currentIndex + 1) % slides.length;
        goToSlide(newIndex);
    }
    
    function prevSlide() {
        const newIndex = (currentIndex - 1 + slides.length) % slides.length;
        goToSlide(newIndex);
    }
    
    function updateDots() {
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }
    
    function startAutoPlay() {
        if (intervalId) return; 
        intervalId = setInterval(nextSlide, SLIDE_INTERVAL);
    }
    
    function stopAutoPlay() {
        clearInterval(intervalId);
        intervalId = null;
    }
    
    function resetAutoPlay() {
        stopAutoPlay();
        startAutoPlay();
    }
    
    document.addEventListener('visibilitychange', () => {
        document.hidden ? stopAutoPlay() : startAutoPlay();
    });
    
    initSlider();
});