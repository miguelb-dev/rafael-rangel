document.addEventListener('DOMContentLoaded', () => {
    const faqItems = document.querySelectorAll('.faq__item');

    faqItems.forEach(item => {
        const pregunta = item.querySelector('.question');
        const boton = item.querySelector('.question__botton');

        pregunta.addEventListener('click', () => {
        item.classList.toggle('activo');

        // Cambiar el botón "+" a "-" y viceversa
        if (item.classList.contains('activo')) {
            boton.textContent = '-';
        } else {
            boton.textContent = '+';
        }
        });
    });
});