document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const $carousel = document.querySelector('.carousel');
    const $carouselList = $carousel.querySelector('ul');
    const $prevBtn = $carousel.querySelector('.prev-btn');
    const $nextBtn = $carousel.querySelector('.next-btn');
    const $indicators = $carousel.querySelectorAll('.carousel-indicators button');
            
    // Variables de estado
    let currentIndex = 0;
    const totalItems = $carouselList.children.length;
            
    // Función para actualizar el carrusel
    function updateCarousel() {
        // Mueve el carrusel a la imagen actual
        $carouselList.style.marginLeft = `-${currentIndex * 100}%`;
                
        // Actualiza los indicadores
        $indicators.forEach((indicator, index) => {
            if (index === currentIndex) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
            
    // Evento para el botón anterior
    $prevBtn.addEventListener('click', function() {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        updateCarousel();
    });
            
    // Evento para el botón siguiente
    $nextBtn.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % totalItems;
        updateCarousel();
    });
            
    // Eventos para los indicadores
    $indicators.forEach(indicator => {
        indicator.addEventListener('click', function() {
            currentIndex = parseInt(this.getAttribute('data-index'));
            updateCarousel();
        });
    });
            
    // Autoavance del carrusel cada 6 segundos
    let autoSlide = setInterval(() => {
        currentIndex = (currentIndex + 1) % totalItems;
        updateCarousel();
    }, 6000);
});