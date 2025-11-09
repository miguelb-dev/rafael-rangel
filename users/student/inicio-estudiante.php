<?php 
require_once 'verificar-sesion.php'; 
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>C.E Rafael Rangel</title>

    <link rel="stylesheet" href="../../assets/css/font.css">
    <link rel="stylesheet" href="../../assets/css/global.css">
    <link rel="stylesheet" href="../../assets/css/index-styles.css">
    <link rel="icon" href="../../assets/img/favicon.png">
</head>
<body>
    <div class="layout">
        
        <!-- === HEADER SECTION === -->
        <header class="header">
            
            <div class="header__container">

                <img class="header__logo" src="../../assets/img/favicon.png">

                <h1 class="header__title">Complejo Educativo Rafael Rangel</h1>

                <!-- Redes del Complejo Educativo -->
                <ul class="header__social-media">
                    <li class="social-media__li">
                        <a class="social-media__link" href="https://www.facebook.com/liceobolibariano.rafaelrangel" target="_blank">
                            <svg class="social-media__logo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                        </a>
                    </li>
                    <li class="social-media__li">
                        <a class="social-media__link" href="https://www.instagram.com/rafaelrangel852021/" target="_blank">
                            <svg class="social-media__logo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M16.5 7.5v.01" /></svg>
                        </a>
                    </li>
                    <li class="social-media__li">
                        <a class="social-media__link" href="https://x.com/RAFAELR15973838" target="_blank">
                            <svg class="social-media__logo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" /><path d="M9 8l6 8" /><path d="M15 8l-6 8" /></svg>
                        </a>
                    </li>
                </ul>
            </div>

            <nav class="header__nav">
                <!-- Menú para Móviles -->
                <button class="nav__hamburger" aria-label="Abrir menú">
                    <svg class="hamburger-icon" viewBox="0 0 24 24" width="24" height="24"> <path fill="currentColor" d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
                    
                    <svg class="close-icon" viewBox="0 0 24 24" width="24" height="24" style="display:none;"><path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                </button>
                
                <!-- Menú de Navegación -->
                <ul class="nav__ul">
                    <li class="ul__item"><a class="ul__link" href="inicio-estudiante.php">Inicio</a></li>
                    <li class="ul__item"><a class="ul__link" href="calendar-estudiante.php">Calendario</a></li>
                    <li class="ul__item"><a class="ul__link" href="professors-summary/professors-summary.php">Materias y Docentes</a>
                    <li class="ul__item"><a class="ul__link" href="academic-summary/academic-summary.php">Resumen Académico</a>
                    <li class="ul__item"><a class="ul__link" href="about-us-estudiante.php"> Sobre Nosotros </a></li>
                    <li class="ul__item"><a class="ul__link" href="help-estudiante.php">Ayuda</a></li>
                    <li class="ul__item ul__item--sign-in"><a class="ul__link" href="../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>
        
        <!-- Carrusel de fotogrofías del complejo -->
        <div class="carousel">
            <div class="welcome-container">
                <h2>Medio Informativo para uso institucional</h2>
                <p>Visita las secciones de interés de nuestra plataforma</p>
            </div>
            <ul>
                <li>
                    <img src="../../assets/img/photos/gate.jpg" alt="Entrada del Rangel">
                </li>
                <li>
                    <img src="../../assets/img/photos/event.jpg" alt="Estudiantes del Rangel">
                </li>
                <li>
                    <img src="../../assets/img/photos/square.jpg" alt="Plaza del Rafael Rangel">
                </li>
                <li>
                    <img src="../../assets/img/photos/wall.jpg" alt="Mural de Rafael Rangel">
                </li>
            </ul>
            
            <button class="carousel-btn prev-btn">&#10094;</button>
            <button class="carousel-btn next-btn">&#10095;</button>
            
            <!-- Indicadores del carrusel -->
            <div class="carousel-indicators">
                <button class="active" data-index="0"></button>
                <button data-index="1"></button>
                <button data-index="2"></button>
                <button data-index="3"></button>
            </div>
        </div>

        
        <!-- === MAIN SECTION === -->
        <main>
            <div class="post-container" id="post-container">
                
                <!-- Las publicaciones se cargarán aquí dinámicamente -->
            
            </div>
        </main>
        

        <!-- === ASIDE SECTION === -->
        <aside class="extra-information">
            <div class="extra__image-wrapper">
                <img class="extra__image" src="../../assets/img/photos/rafael-rangel.jpg" alt="Fotogrofía de Rafael Rangel">
            </div>
            <p class="extra__description">Dentro de la ciudad de Valera se encuentra ubicado el Complejo Educativo Rafael Rangel, fundado el 28 de septiembre de 1936 y siendo considerado como una de las instituciones educativas de mayor prestigio nacional. En sus inicios, se le atribuyó el nombre de "Colegio Federal" al igual que otros recintos a lo largo de la geografía nacional; pero destacando y con diferencia, por sus altos estándares de calidad en la formación académica. Es la casa de estudio por excelencia para los jóvenes valeranos quienes construirán el mañana de nuestra pequeña valera...<a class= "extra__link" href="about-us-estudiante.php">Leer más</a>
            </p>
            <p class="extra__phrase">"¡Es grande ser Rangeliano!"</pclaas>
        </aside>


        <!-- === FOOTER SECTION === -->
        <footer class="footer">
            <p class="footer__description"> Ubícanos: </p>
            <p class="footer__description"> Avenida 6 con calle Río de Janeiro, sector La Plata. Parroquia Juan Ignacio Montilla, municipio Valera, estado Trujillo </p>
            <p class="footer__description"> Complejo Educativo Rafael Rangel &copy; 2025 </p>
        </footer>

    </div>

    <script src="../../assets/js/nav-bar.js"></script>
    <script src="../../assets/js/carousel-buttons.js"></script>
    <script src="../../assets/js/load-posts.js"></script>
</body>
</html>