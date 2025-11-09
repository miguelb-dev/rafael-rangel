<?php 
require_once 'verificar-sesion.php'; 
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Sobre Nosotros</title>

    <link rel="stylesheet" href="../../assets/css/font.css">
    <link rel="stylesheet" href="../../assets/css/global.css">
    <link rel="stylesheet" href="../../assets/css/about-us-styles.css">
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
                    <li class="ul__item"><a class="ul__link" href="inicio-docente.php">Inicio</a></li>
                    <li class="ul__item"><a class="ul__link" href="calendar-docente.php">Calendario</a></li>
                    <li class="ul__item"><a class="ul__link" href="student-management/student-management.php">Gestión de Estudiantes</a></li> 
                    <li class="ul__item"><a class="ul__link" href="about-us-docente.php"> Sobre Nosotros </a></li>
                    <li class="ul__item"><a class="ul__link" href="help-docente.php">Ayuda</a></li>
                    <li class="ul__item ul__item--sign-in"><a class="ul__link" href="../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>


        <!-- === MAIN SECTION === -->
        <main>
            <h1 class="main__title">Sobre Nosotros</h1>
            <div class="main__container">
                <section class="history">
                    <h2 class="history__title">Reseña Histórica</h2>
                    <img class="history__img" src="../../assets/img/photos/rafael-rangel.jpg" alt="Fotogrofía de Rafael Rangel">
                    <p class="history__description">Dentro del municipio Valera se encuentra el Complejo Educativo Rafael Rangel, el cual nace el 28 de septiembre de 1936, considerado una de las instituciones educativas de mayor prestigio nacional. En sus primeros tiempos se atribuyó el nombre de "Colegio Federal" al igual que otros recintos diseminados a lo largo de la geografía nacional; desde entonces, se ha considerado como un momento relevante que marcó pauta para aperturar caminos seguros en la pequeña Valera. Es importante destacar, que hombres insignes para la época como Monseñor Mejía y el General Juan Bautista Araujo, fueron pilares fundamentales en el Colegio Federal de Valera.

El Decreto de Creación del Colegio Federal del General Eleazar López Contreras resume el signo de su gobierno; el cual estaba en la búsqueda de un nuevo país. La existencia de dicho colegio y la adopción de este, no estuvo separado del contexto nacional, ni del conjunto de aquellos cambios sociales; ya que su consolidación, fue una demostración de una nueva experiencia educativa.

No obstante, para el año de 1947, cuando el Colegio Federal es elevado a categoría de Liceo, Valera asume una visión futurista y recibe la denominación como Liceo "Rafael Rangel", quien fue un insigne trujillano, hombre vinculado de manera directa en el ámbito científico e investigador por excelencia en las Ciencias Médicas. De esta manera, asume el nombre de Rafael Rangel.

Durante los siguientes años, se comienza a aperturar y consolidar espacios para preparar nuevamente al liceo e iniciar la formación académica para generaciones con verdadero arraigo.

Precisamente para el año 1951, a través del documento Nº32 con fecha del 10 de agosto, se le otorga oficialmente el nombre de Liceo Rafael Rangel, que inicia su funcionamiento en la actual Avenida 6 sector la Plata de la ciudad de Valera, estudiándose en ese momento solamente hasta cuarto año de secundaria.

Con el advenimiento de la etapa democrática en 1958, se consolida el Segundo Ciclo de Humanidades y Ciencias; y es para el año escolar 1958-1959 cuando egresa la primera promoción que llevó el nombre de "Rafael Rangel", siendo este el único liceo público de enseñanza secundaria.

Es en 1972, cuando se establece ministerialmente el Ciclo Diversificado en las especialidades de Ciencias, Humanidades, Mercadeo y Comercio, y en el mismo año se agrega Contabilidad. Luego, para el año 1975 se eliminaron las especialidades de Humanidades, Mercadeo y Contabilidad, quedando el Liceo solo con la especialidad de Ciencias, aunque a partir de 1980 se agrega nuevamente el Diversificado de Humanidades, manteniéndose estás dos especialidades hasta 1988 cuando se crean las menciones de Turismo y Deportes, con tres años de especialidad y la obtención del título en Técnico Medio.

Ya para el año 2006, el liceo asume la figura de Liceo Bolivariano Rafael Rangel; ofertándose dos niveles: Nivel I, desde el Primer al Tercer año y Nivel II, desde el Cuarto al Quinto Año de secundaria; esto gracias al acuerdo establecido en la resolución Nº35 que deroga la resolución Nº213 del 15 de marzo de 1989, pero dicho acuerdo se inicia a partir del decreto Nº38.490 del 01 del 2006.

Cinco años después, a pesar de que dicha resolución no fue derogada explícitamente; la zona educativa declaró que a los liceos públicos de la localidad de Valera y de las demás partes del país, exceptuando algunos casos puntuales; se les había eliminado el “Bolivariano” del nombre (continúan perteneciendo a tal categoría, pero ya no se les denomina de esa manera). Por consiguiente, el Liceo Bolivariano Rafael Rangel, recupera su nombre original de Liceo Rafael Rangel.

Sin embargo, en la actualidad, el Ministerio del Poder Popular para la Educación ha declarado el nuevo cambio de nombre a Complejo Educativo Rafael Rangel, esto debido a que la institución no realiza únicamente laborales de enseñanza para los jóvenes, sino que además a adultos en su culminación de estudios de bachillerato y a técnicos en diferentes ramas del conocimiento. Por tanto, se decidió por añadirse el Complejo Educativo, para generalizar y ser más acorde a su realidad.

Así pues, todo el recorrido histórico presentado es de gran relevancia para expresar que esta prestigiosa institución ha tenido gran arraigo en la colectividad valerana, caracterizada por un gran sentido de pertenencia y solidez. El Rangel, desde que aperturó sus puertas por primera vez a la juventud pujante, decidida, estudiosa y deseosa por cristalizar sus sueños, que con amor han recorrido sus aulas y pasillos, han obtenido una formación educativa plena, valiosa, que los ha formado y seguirá formando a hombres y mujeres de elevada excelencia, representado desde sus espacios con fervor y orgullo su querida casa de estudio.

De igual manera, son innumerables los docentes y venezolanos auténticos rangelianos que han dado invalorables aportes en los diferentes campos de la Ciencia, la Política, la Educación, la Cultura y el Deporte; que al mismo tiempo han sabido identificarse plenamente con las luchas del pueblo en pro del establecimiento de relaciones justas e igualitarias en el seno de la sociedad y al servicio de la Comunidad.

Se resume entonces esta reseña con las sabias, simbólicas e inolvidables palabras de la insigne y siempre recordada Profesora Lesbia Rodríguez de Portes, docente con verdadera vocación, quien en 30 años de servicio magisterial, 18 de ellos como Directora del Liceo, expreso:

<span class="description__phrase">“El corazón de Valera palpita en el Liceo Rafael Rangel”</span>

Esta es una verdad que se reafirma con lo también expresado por la Profesora Zoraida Hernández, y que hoy por hoy es el eslogan vivo, palpitante en el corazón de toda aquella persona que se identifica, se enamora, vive y hace suyo de esta institución, definitivamente:

<span class="description__phrase">“¡Es grande ser Rangeliano!”</span></p>
                </section>
                
                <div class="mvl-container">
                    <section class="mission">
                        <h2 class="mission__title">Misión</h2>
                        <p class="mission__description">Somos una comunidad de aprendizaje pública, con visión futurista, generadora de cambios, con liderazgo académico, deberes y derechos mutuos, orientada a la formación integral de excelentes ciudadanos: críticos, reflexivos, creativos, seguros y responsables de su rol protagónico en la transformación social de la vida comunitaria, acorde a los avances tecnológicos, investigativos, culturales y ambientales. Atendiendo a los principios de participación, autonomía, democracia y paz en función de un aprendizaje de servicio que afiance al desarrollo endógeno sustentable y soberano; nacional, regional y local del país.</p>
                    </section>

                    <section class="vision">
                        <h2 class="vision__title">Visión</h2>
                        <p class="vision__description">Ser un centro educativo de excelencia académica, elevada calidad humana, protagónica, participativa, democrática. Formadores de estudiantes con vocación de servicio, capaces de valorarse a sí mismos y por ende a su comunidad sustentada en valores de amor, solidaridad, corresponsabilidad, paz, respeto y justicia, que permitirán optimizar y afianzar el compromiso de educar por y para la vida.</p>
                    </section>

                    <section class="location">
                        <h2 class="location__title">Ubicación</h2>
                        <p class="location__description">Avenida 6 con calle Río de Janeiro, sector La Plata. Parroquia Juan Ignacio Montilla, municipio Valera, estado Trujillo</p>
                    </section>
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
</body>
</html>