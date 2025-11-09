<?php 
require_once 'verificar-sesion.php'; 
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Ayuda y Soporte</title>

    <link rel="stylesheet" href="../../assets/css/font.css">
    <link rel="stylesheet" href="../../assets/css/global.css">
    <link rel="stylesheet" href="../../assets/css/help-styles.css">
    <link rel="icon" href="../../assets/img/favicon.png">
</head>
<body>
    <div class="layout">
        
        <!-- === HEADER SECTION === -->
        <header class="header">
            
            <div class="header__container">

                <img class="header__logo" src="../../assets/img/favicon.png">

                <p class="header__title">Complejo Educativo Rafael Rangel</p>

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
                    <li class="ul__item"><a class="ul__link" href="inicio-admin.php">Inicio</a></li>
                    <li class="ul__item"><a class="ul__link" href="calendar-admin.php">Calendario</a></li>
                    <li class="ul__item"><a class="ul__link" href="student-management/student-management.php">Gestión de Estudiantes</a></li>
                    <li class="ul__item"><a class="ul__link" href="professor-management/professors-management.php">Gestión de Docentes</a></li>
                    <li class="ul__item"><a class="ul__link" href="about-us-admin.php"> Sobre Nosotros </a></li>
                    <li class="ul__item"><a class="ul__link" href="help-admin.php">Ayuda</a></li>
                    <li class="ul__item ul__item--sign-in"><a class="ul__link" href="../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>

        
        <!-- === MAIN SECTION === -->
        <main>
            <div class="help-container">
                
                <h1>Ayuda y Soporte</h1>
            
                <div class="faq-container">
                    <!-- Pregunta 1 -->
                    <div class="faq__item">
                        <div class="question">
                            <h2 class="question__title">¿Cómo puedo ver mis calificaciones?</h2>
                            <button class="question__botton">+</button>
                        </div>
                        <div class="answer">
                            <p>Puedes acceder a tus calificaciones e inasistencias desde la sección <strong>"Resumen Académico"</strong> en el menú principal. Pero debes iniciar sesión con tu usuario y contraseña para visualizarlas.</p>
                        </div>
                    </div>

                    <!-- Pregunta 2 -->
                    <div class="faq__item">
                        <div class="question">
                            <h2 class="question__title">¿Cómo puedo ingresar en la aplicación como Docente?</h2>
                            <button class="question__botton">+</button>
                        </div>
                        <div class="answer">
                            <p>Si usted es un Docente, para poder ingresar en nuestra plataforma, necesita que el admnistrador le asigne una cuenta como Docente, para ello, deberá seguir los siguentes pasos:</p>
                            <ul>
                                <li>Tendrá que enviar un correo electrónico con su informacion de contacto (N° de cédula, nombre, apellido, correo electrónico, N° de teléfono, dirección y fecha de nacimiento) junto con su explicación de que desea ingresar en nuestra plataforma como Docente, al correo:  <em>soporterafaelrangel@gmail.com</em>.</li>
                                <li>Tendrá que esperar un periodo máximo de 5 días para que un administrador apruebe su solicitud.</li>
                                <li>En caso de ser aprobado/desaprobado, se le notificará con un correo de confirmación/negación.</li>
                                <li>Si supera el periodo de espera y no recibe ninguna respuesta, se recomienda dirigirse personalmente a la institución.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Pregunta 3 -->
                    <div class="faq__item">
                        <div class="question">
                            <h2 class="question__title">¿Cómo contacto a un docente?</h2>
                            <button class="question__botton">+</button>
                        </div>
                        <div class="answer">
                            <p>Revisa la sección <strong>"Materias y Docentes"</strong> donde encontrarás el correo electrónico de todos tus profesores, y de estar disponible, también sus números telefónicos. Pero deberás iniciar sesión con tu usuario y contraseña para poder visualizarla.</p>
                        </div>
                    </div>

                    <!-- Pregunta 4 -->
                    <div class="faq__item">
                        <div class="question">
                            <h2 class="question__title">¿Dónde encuentro el horario de clases?</h2>
                            <button class="question__botton">+</button>
                        </div>
                        <div class="answer">
                            <p> El horario está disponible en la sección <strong>"Resumen Académico"</strong> una vez inicies sesión. También se publica en el tablero de anuncios en la sección de <strong>Inicio</strong>.</p>
                        </div>
                    </div>

                    <!-- Pregunta 5 -->
                    <div class="faq__item">
                        <div class="question">
                            <h2 class="question__title">¿La plataforma funciona en dispositivos móviles?</h2>
                            <button class="question__botton">+</button>
                        </div>
                        <div class="answer">
                            <p>Sí, nuestra plataforma es <strong>compatible con dispositivos móviles</strong>. Puedes acceder desde cualquier navegador en tu teléfono o tablet. Sin embargo, algunas secciones de la plataforma pueden ser más cómodas de visualizar en computadoras.</p>
                        </div>
                    </div>

                    <!-- Pregunta 6 -->
                    <div class="faq__item">
                        <div class="question">
                            <h2 class="question__title">¿Tienes algún problema con nuestra plataforma?</h2>
                            <button class="question__botton">+</button>
                        </div>
                        <div class="answer">
                            <p>De presentar algún problema, por favor, comunícate con nuestro equipo de soporte al correo electrónico <em>soporterafaelrangel@gmail.com</em>.</p>
                        </div>
                    </div>
                </div>

            </div>
            
        </main>


        <!-- === FOOTER SECTION === -->
        <footer class="footer">
            <p class="footer__description"> Ubícanos: </p>
            <p class="footer__description"> Avenida 6 con calle Río de Janeiro, sector La Plata. Parroquia Juan Ignacio Montilla, municipio Valera, estado Trujillo </p>
            <p class="footer__description"> Complejo Educativo Rafael Rangel &copy; 2025 </p>
        </footer>
    </div>

    <script src="../../assets/js/nav-bar.js"></script>
    <script src="../../assets/js/help-list.js"></script>
</body>
</html>