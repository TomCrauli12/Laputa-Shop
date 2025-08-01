let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

// Функция для показа слайда
function showSlide(index) {
    slides.forEach(slide => {
        slide.classList.remove('active')
    });
    slides[index].classList.add('active');
    dots.forEach(dot => dot.classList.remove('active'));
    dots[index].classList.add('active');
}

// Функция для смены слайда
function nextSlide() {
    slideIndex = (slideIndex + 1) % slides.length;
    showSlide(slideIndex);
}

// Функция для предыдущего слайда
function prevSlide() {
    slideIndex = (slideIndex - 1 + slides.length) % slides.length;
    showSlide(slideIndex);
}

// Автоматическая смена слайда каждые 5 секунд
setInterval(nextSlide, 50000);

// События для кнопок
prevButton?.addEventListener('click', prevSlide);
nextButton?.addEventListener('click', nextSlide);

// События для точек
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        slideIndex = index;
        showSlide(slideIndex);
    });
});




const icons = document.querySelectorAll('.icon');
icons.forEach (icon => {  
  icon.addEventListener('click', (event) => {
    icon.classList.toggle("open");
  });
});




