document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.nav__hamburger');
    const menu = document.querySelector('.nav__ul');
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    const closeIcon = document.querySelector('.close-icon');
    
    hamburger.addEventListener('click', function() {
        menu.classList.toggle('active');
        
        // Cambiar entre icono de hamburguesa y X
        if (menu.classList.contains('active')) {
            hamburgerIcon.style.display = 'none';
            closeIcon.style.display = 'block';
            document.body.style.overflow = 'hidden';
        } else {
            hamburgerIcon.style.display = 'block';
            closeIcon.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Cerrar menú al hacer clic en un enlace
    const navLinks = document.querySelectorAll('.ul__link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                menu.classList.remove('active');
                hamburgerIcon.style.display = 'block';
                closeIcon.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    });


    // Marcar la página actual en la barra de navegación

    const currentPage = window.location.pathname.split('/').pop();
    const $navLinks = document.querySelectorAll('.ul__link')
    
    for (let i=0; i < $navLinks.length; i++){
        
        let href = $navLinks[i].getAttribute('href')
        let archivo = href.split('/').pop()

        if (archivo == currentPage) {
            $navLinks[i].id = 'current-position'
        }
    }


});



/*     // Marcar la página actual en la barra de navegación

    const $body = document.querySelector('body');
    const currentPage = $body.getAttribute('data-page-type')
    console.log(`La pagina actual es: ${currentPage}`)

    const $navLinks = document.querySelectorAll('.ul__link')
    
    for (let i=0; i < $navLinks.length; i++){
        let link = $navLinks[i].getAttribute('data-page')
        if (link == currentPage) {
            $navLinks[i].id = 'current-position'
            console.log($navLinks[i].id)
        }
    }
 */