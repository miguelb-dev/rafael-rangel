<?php 
require_once '../verificar-sesion.php';
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Publicaciones</title>

    <link rel="stylesheet" href="../../../assets/css/font.css">
    <link rel="stylesheet" href="../../../assets/css/global.css">
    <link rel="stylesheet" href="../../../assets/css/events-posts-management-styles.css">
    <link rel="icon" href="../../../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body data-page-type="posts-management">
    <div class="layout">
        
        <!-- === HEADER SECTION === -->
        <header class="header">
            
            <div class="header__container">

                <img class="header__logo" src="../../../assets/img/favicon.png">

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
                    <li class="ul__item"><a class="ul__link" href="../inicio-admin.php">Inicio</a></li>
                    <li class="ul__item"><a class="ul__link" href="../calendar-admin.php">Calendario</a></li>
                    <li class="ul__item"><a class="ul__link" href="../student-management/student-management.php">Gestión de Estudiantes</a></li> 
                    <li class="ul__item"><a class="ul__link" href="../professor-management/professors-management.php">Gestión de Docentes</a></li> 
                    <li class="ul__item"><a class="ul__link" href="../about-us-admin.php"> Sobre Nosotros </a></li>
                    <li class="ul__item"><a class="ul__link" href="../help-admin.php">Ayuda</a></li>
                    <li class="ul__item ul__item--sign-in"><a class="ul__link" href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>


        <!-- === MAIN SECTION === -->
        <main>  
            <form class="form" enctype="multipart/form-data">
                <header class="form__header">
                    <h1 class="form__title">Crear publicación</h1>

                    <div class="action-buttons-wrapper">
                        <button id="add" class="user-selection" type="button"><i class="fa-solid fa-plus"></i></button>
                        <button id="edit" type="button"><i class="fa-solid fa-pencil"></i></button>
                        <button id="delete" type="button"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </header>
        
                <div class="form__inputs-container">
                    <div class="select-wrapper">
                        <label for="title">Título</label>
                        <input id="title" class="input__field" type="text" required>
                    </div>

                    <label for="description">Descripción</label>
                    <textarea id="description" class="input__field"></textarea>

                    <label for="images">Imágenes (opcional)</label>
                    <input id="images" class="input__field" type="file" name="images[]" accept="image/*" multiple>
                    <div id="preview-images" class="preview-container"></div>

                    <label for="documents">Documentos (opcional)</label>
                    <input id="documents" class="input__field" type="file" name="documents[]" accept=".doc,.docx,.xls,.xlsx,.pdf" multiple>
                    <div id="preview-documents" class="preview-container"></div>

                </div>

                <div class="status-buttons-wrapper">
                    <button id="save" type="submit">Crear</button>
                    <button id="cancel" type="reset">Cancelar</button>
                </div>
            </form>
        </main>


        <!-- === FOOTER SECTION === -->
        <footer class="footer">
            <p class="footer__description"> Ubícanos: </p>
            <p class="footer__description"> Avenida 6 con calle Río de Janeiro, sector La Plata. Parroquia Juan Ignacio Montilla, municipio Valera, estado Trujillo </p>
            <p class="footer__description"> Complejo Educativo Rafael Rangel &copy; 2025 </p>
        </footer>
    </div>

    <script src="../../../assets/js/nav-bar.js"></script>
    <script src="../../../assets/js/posts-management.js"></script>
</body>
</html>