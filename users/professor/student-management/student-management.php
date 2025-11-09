<?php 
require_once '../verificar-sesion.php';

// Controlar estado del formulario después de errores
$mostrarFormularioEditar = isset($_GET['error']) && isset($_GET['form']) && $_GET['form'] === 'editar';


//* Carga en el filtro únicamente las asignaturas y años/sección que da el docente
// Obtener el ID del docente desde la sesión
$id_docente = $_SESSION['id_docente'];

// Conectar a la base de datos y obtener las materias del profesor
require_once '../../config/data-base.php';
$materias_docente = [];
$secciones_docente = [];

try {
    // Obtener materias del docente
    $stmt = $conexion->prepare("
        SELECT 
            a.id_asignatura,
            a.nombre AS nombre_asignatura
        FROM docente d
        JOIN docente_asignatura_anio_seccion daas 
            ON d.id_docente = daas.id_docente
        JOIN asignatura a 
            ON daas.id_asignatura = a.id_asignatura
        WHERE d.id_docente = :id_docente
        ORDER BY a.nombre
    ");
    $stmt->bindParam(':id_docente', $id_docente, PDO::PARAM_INT);
    $stmt->execute();
    $materias_docente = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener años y secciones del docente
    $stmt2 = $conexion->prepare("
        SELECT DISTINCT
            asec.id_anio_seccion,
            asec.anio,
            asec.seccion
        FROM anio_seccion asec
        JOIN docente_asignatura_anio_seccion daas 
            ON asec.id_anio_seccion = daas.id_anio_seccion
        JOIN docente d 
            ON daas.id_docente = d.id_docente
        WHERE d.id_docente = :id_docente
        ORDER BY asec.anio, asec.seccion
    ");
    $stmt2->bindParam(':id_docente', $id_docente, PDO::PARAM_INT);
    $stmt2->execute();
    $secciones_raw = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Crear el array de secciones con el formato que necesitas
    foreach ($secciones_raw as $seccion) {
        $secciones_docente[$seccion['id_anio_seccion']] = $seccion['anio'] . "° " . $seccion['seccion'];
    }

} catch (PDOException $e) {
    // En caso de error, puedes manejarlo aquí
    error_log("Error al obtener datos del docente: " . $e->getMessage());
}

// Captura previa para persistencia visual
$materia = isset($_GET['materia']) ? $_GET['materia'] : '';
$id_anio_seccion = isset($_GET['anio_seccion']) ? $_GET['anio_seccion'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gestión de  Estudiantes</title>

    <link rel="stylesheet" href="../../../assets/css/font.css">
    <link rel="stylesheet" href="../../../assets/css/global.css">
    <link rel="stylesheet" href="../../../assets/css/student-professors-management-styles.css">
    <link rel="icon" href="../../../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body data-page-type="student-management">
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
                    <li class="ul__item"><a class="ul__link" href="../inicio-docente.php">Inicio</a></li>
                    <li class="ul__item"><a class="ul__link" href="../calendar-docente.php">Calendario</a></li>
                    <li class="ul__item"><a class="ul__link" href="student-management.php">Gestión de Estudiantes</a></li>  
                    <li class="ul__item"><a class="ul__link" href="../about-us-docente.php"> Sobre Nosotros </a></li>
                    <li class="ul__item"><a class="ul__link" href="../help-docente.php">Ayuda</a></li>
                    <li class="ul__item ul__item--sign-in"><a class="ul__link" href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>



        <!-- === MAIN SECTION === -->
        <main id="crud-wrapper" style="display: <?php echo ($mostrarFormularioEditar) ? 'none' : 'block'; ?>;">
            <h1 class="main__title">Gestión de Estudiantes</h1>
            <div class="table-container">

                <div class="icons-container">
                    <div class="order-wrapper">
                        <form method="GET" class="form-filter">
                            <div class="filter-group-wrapper">
                                <div class="filter-group">
                                    <label for="materia">Materia:</label>
                                    <select name="materia" id="materia" class="order-by">
                                        <option value="" <?= $materia === '' ? 'selected' : '' ?>>-- Todas --</option>
                                        <?php
                                        foreach ($materias_docente as $materia_docente) {
                                            $selected = ($materia === $materia_docente['nombre_asignatura']) ? 'selected' : '';
                                            echo "<option value=\"{$materia_docente['nombre_asignatura']}\" $selected>{$materia_docente['nombre_asignatura']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
        
                                <div class="filter-group">
                                    <label for="anio_seccion">Año y Sección:</label>
                                    <select name="anio_seccion" id="anio_seccion" class="order-by">
                                        <option value="" <?= $id_anio_seccion === '' ? 'selected' : '' ?>>-- Todos --</option>
                                        <?php
                                        foreach ($secciones_docente as $id => $label) {
                                            $selected = ($id_anio_seccion == $id) ? 'selected' : '';
                                            echo "<option value=\"$id\" $selected>$label</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
    
                            <button type="submit" id="form-button">Filtrar</button>
                        </form>
                        
                    </div>

                    <div class="status-buttons-wrapper">
                        <button class="save" id="erase">Eliminar</button>
                        <button class="cancel">Cancelar</button>
                    </div>

                    <div class="action-buttons-wrapper">
                        <button class="edit"><i class="fa-solid fa-pencil"></i></button>
                        <button class="delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>

                

                <form id="form-table" action="eliminar-estudiante.php" method="POST">

                    <table id="students-table" class="table">
                        <thead>
                            <tr>
                                <th rowspan="2" class="seleccion-edicion" style="display: none;"></th> <!-- radio para editar -->
                                <th rowspan="2" class="seleccion-col" style="display: none;"></th>     <!-- checkbox para eliminar -->
                                <th rowspan="2" style="display:none;"></th>                            <!-- botón oculto con datos -->
                                <th rowspan="2">Cédula</th>
                                <th rowspan="2">Nombres</th>
                                <th rowspan="2">Apellidos</th>
                                <th rowspan="2">Año</th>
                                <th rowspan="2">Sección</th>
                                <th rowspan="2">Materia</th>
                                <th colspan="3">Calificaciones</th>
                                <th colspan="3">Inasistencias</th>
                            </tr>
                            <tr>
                                <th>1er lapso</th>
                                <th>2do lapso</th>
                                <th>3er lapso</th>
                                <th>1er lapso</th>
                                <th>2do lapso</th>
                                <th>3er lapso</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php include('obtener-estudiante.php'); ?>
                        </tbody>
                    </table>
                </form>

            </div>
        </main>


        <!-- === FORMULARIO PARA EDITAR CALIFICACIONES E INASISTENCIAS === -->
        <section class="form-section" id="edit-form-wrapper" style="display: <?php echo $mostrarFormularioEditar ? 'block' : 'none'; ?>;">
            
            <!-- Título del formulario -->
            <h2 class="form-section__title">Calificaciones e Inasistencias</h2>

            <!-- Mensaje de error si el backend redirige con ?error=... -->
            <?php include 'mensaje-error-estudiante.php'; ?>

            <!-- Formulario principal que envía los datos al backend -->
            <form action="editar-estudiante.php" method="POST" class="form-student">

                <!--  ID interno del estudiante (clave primaria real, no la cédula) -->
                <input type="hidden" name="id_estudiante" id="edit-id"> <!--  Este campo debe llenarse con btn.dataset.id_estudiante -->

                <!--  Claves foráneas necesarias para guardar en periodo_escolar -->
                <input type="hidden" name="id_asignatura" id="edit-id_asignatura">
                <input type="hidden" name="id_anio_seccion" id="edit-id_anio_seccion">

                <!--  ID de la relación estudiante-asignatura-año-sección -->
                <input type="hidden" name="id_estudiante_asignatura" id="edit-id_estudiante_asignatura">

                <!-- === DATOS DEL ESTUDIANTE (solo lectura) === -->
                <fieldset id="student-information">
                    <legend>Datos del Estudiante</legend>
                    
                    <!-- Cédula del estudiante (solo visual) -->
                    <label for="cedula">Cédula
                        <input type="text" name="cedula" id="edit-cedula" readonly pattern="\d{7,8}" title="La cédula debe tener entre 7 y 8 dígitos" maxlength="8">
                    </label>

                    <!-- Nombres del estudiante -->
                    <label for="nombre">Nombres
                        <input type="text" name="nombre" id="edit-nombre" readonly>
                    </label>

                    <!-- Apellidos del estudiante -->
                    <label for="apellido">Apellidos
                        <input type="text" name="apellido" id="edit-apellido" readonly>
                    </label>
                </fieldset>

                <!-- Nombre de la asignatura (solo visual, no editable) -->
                <p id="assignature-name">Asignatura</p>

                <!-- === BLOQUE DE CALIFICACIONES === -->
                <fieldset>
                    <legend>Calificaciones</legend>

                    <div class="califications-container">
                        <label for="nota-lapso1">Primer Lapso
                            <input id="nota-lapso1" name="nota_lapso1" type="number" min="0" max="20">
                        </label>
    
                        <label for="nota-lapso2">Segundo Lapso
                            <input id="nota-lapso2" name="nota_lapso2" type="number" min="0" max="20">
                        </label>
    
                        <label for="nota-lapso3">Tercer Lapso
                            <input id="nota-lapso3" name="nota_lapso3" type="number" min="0" max="20">
                        </label>
                    </div>
                </fieldset>

                <!-- === BLOQUE DE INASISTENCIAS === -->
                <fieldset>
                    <legend>Inasistencias</legend>

                    <div class="absences-container">
                        <label for="inasistencia-lapso1">Primer Lapso
                            <input id="inasistencia-lapso1" name="inasistencia_lapso1" type="number" min="0">
                        </label>
    
                        <label for="inasistencia-lapso2">Segundo Lapso
                            <input id="inasistencia-lapso2" name="inasistencia_lapso2" type="number" min="0">
                        </label>
    
                        <label for="inasistencia-lapso3">Tercer Lapso
                            <input id="inasistencia-lapso3" name="inasistencia_lapso3" type="number" min="0">
                        </label>
                    </div>
                </fieldset>

                <!-- === BOTONES DE ACCIÓN DEL FORMULARIO === -->
                <div class="form-buttons-wrapper">                    
                    <!-- Botón para guardar los cambios -->
                    <button type="submit" class="save">Guardar</button>

                    <!-- Botón para cancelar y volver al CRUD -->
                    <button id="cancel-edit" type="button" class="cancel-edit">Cancelar</button>
                </div>

            </form>
        </section>




        <!-- === FOOTER SECTION === -->
        <footer class="footer">
            <p class="footer__description"> Ubícanos: </p>
            <p class="footer__description"> Avenida 6 con calle Río de Janeiro, sector La Plata. Parroquia Juan Ignacio Montilla, municipio Valera, estado Trujillo </p>
            <p class="footer__description"> Complejo Educativo Rafael Rangel &copy; 2025 </p>
        </footer>
    </div>

    <script src="../../../assets/js/nav-bar.js"></script>
    <script src="../../../assets/js/student-management.js"></script>
</body>
</html>