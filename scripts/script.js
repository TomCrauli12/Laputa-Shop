document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.slider');
    if (!slider) return;
    
    const container = slider.querySelector('.slides-container');
    const slides = Array.from(slider.querySelectorAll('.slide'));
    const prevBtn = slider.querySelector('.slider-prev');
    const nextBtn = slider.querySelector('.slider-next');
    const dots = Array.from(slider.querySelectorAll('.slider-dot'));
    
    let currentIndex = 0;
    let intervalId;
    

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
    }
    

    function goToSlide(index) {
        if (index === currentIndex) return;
        
        const direction = index > currentIndex ? 'next' : 'prev';
        const newIndex = (index + slides.length) % slides.length;
        

        slides[currentIndex].classList.add(direction);
        slides[newIndex].classList.add(direction);
        
        setTimeout(() => {
            slides[currentIndex].classList.remove('active', 'next', 'prev');
            slides[newIndex].classList.remove('next', 'prev');
            slides[newIndex].classList.add('active');
            
            currentIndex = newIndex;
            updateDots();
        }, 50);
        
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
        stopAutoPlay();
        intervalId = setInterval(nextSlide, 10000);
    }
    
    function stopAutoPlay() {
        clearInterval(intervalId);
    }
    
    function resetAutoPlay() {
        stopAutoPlay();
        startAutoPlay();
    }
    
    initSlider();
});