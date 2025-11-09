<?php 
require_once '../verificar-sesion.php';

// Controlar estado del formulario después de errores
$mostrarFormularioAgregar = isset($_GET['error']) && isset($_GET['form']) && $_GET['form'] === 'agregar';
$mostrarFormularioEditar = isset($_GET['error']) && isset($_GET['form']) && $_GET['form'] === 'editar';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gestión de Docentes</title>

    <link rel="stylesheet" href="../../../assets/css/font.css">
    <link rel="stylesheet" href="../../../assets/css/global.css">
    <link rel="stylesheet" href="../../../assets/css/student-professors-management-styles.css">
    <link rel="icon" href="../../../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body data-page-type="professors-management">
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
                    <li class="ul__item"><a class="ul__link" href="professors-management.php">Gestión de Docentes</a></li>
                    <li class="ul__item"><a class="ul__link" href="../about-us-admin.php"> Sobre Nosotros </a></li>
                    <li class="ul__item"><a class="ul__link" href="../help-admin.php">Ayuda</a></li>
                    <li class="ul__item ul__item--sign-in"><a class="ul__link" href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>
        
        
        <!-- === MAIN SECTION === -->
        <main id="crud-wrapper" style="display: <?php echo ($mostrarFormularioAgregar) ? 'none' : 'block'; ?>;">
            
            <h1 class="main__title">Gestión de Docentes</h1>          
            
            <?php include 'mensaje-error-docente.php';?> <!-- Mensaje de error en el formulario de editar -->
            
            <div class="table-container">
                
                <div class="icons-container">
                    <div class="order-wrapper">
                        <!-- Filtrar por materia -->
                        <form method="GET" id="filtro-materia" class="order-wrapper">
                            <label for="order-by">Filtrar:</label>
                            <select id="order-by" name="materia" class="order-by" onchange="document.getElementById('filtro-materia').submit()">
                                <option value="">-- Todas --</option>
                                <option value="Matemática">Matemática</option> 
                                <option value="Física">Física</option>
                                <option value="Inglés">Inglés</option>
                                <option value="Biología">Biología</option>
                                <option value="Arte y Patrimonio">Arte y Patrimonio</option>
                                <option value="Química">Química</option>
                                <option value="Orientación y Convivencia">Orientación y Convivencia</option>
                                <option value="Formación para la Ciudadanía">Formación para la Ciudadanía</option>
                                <option value="Historia y Geografía">Historia y Geografía</option>
                                <option value="Grupo de Interés">Grupo de Interés</option>
                                <option value="Castellano y Literatura">Castellano y Literatura</option>
                                <option value="Educación Física">Educación Física</option>
                            </select>
                        </form>
                    </div>
                    
                    <div class="status-buttons-wrapper">
                        <button id="erase" class="save" form="form-table" type="submit">Eliminar</button>
                        <button class="cancel" form="form-table" type="button">Cancelar</button>
                    </div>
                    
                    <div class="action-buttons-wrapper">
                        <button type="button" class="add"><i class="fa-solid fa-plus"></i></button>
                        <button class="edit"><i class="fa-solid fa-pencil"></i></button>
                        <button class="delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>
                
                
                <form id="form-table" action="eliminar-docente.php" method="POST">
                    <table id="professors-table" class="table">
                        <thead>
                            <tr>
                                <th class="seleccion-edicion" style="display: none;"></th> <!-- radio para editar -->
                                <th class="seleccion-col" style="display: none;"></th>     <!-- checkbox para eliminar -->
                                <th style="display:none;"></th>                            <!-- botón oculto con datos -->
                                <th>Cédula</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Género</th>
                                <th>Fecha Nacimiento</th>
                                <th>Asignaciones</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php include('obtener-docente.php'); ?>
                        </tbody>
                    </table>
                </form>
                
            </div>

        </main>


        
        
        <!-- === FORMULARIO PARA AGREGAR DOCENTES === -->
        <section class="form-section" id="create-form-wrapper" style="display: <?php echo $mostrarFormularioAgregar ? 'block' : 'none'; ?>;">
            

            <h2 class="form-section__title">Registrar nuevo docente</h2>
            <!-- === MENSAJE DE ERROR EN EL FORMULARIO === -->
            <?php include 'mensaje-error-docente.php'; ?>

            <form action="agregar-docente.php" method="POST" class="form-profesor">

                <!-- Datos del docente -->

                <label for="cedula">Cédula</label>
                <input type="text" name="cedula" id="cedula" required pattern="\d{7,8}" title="La cédula debe tener entre 7 y 8 dígitos" maxlength="8">

                <label for="nombre">Nombres</label>
                <input type="text" name="nombre" id="nombre" required>

                <label for="apellido">Apellidos</label>
                <input type="text" name="apellido" id="apellido" required>

                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>

                <label for="genero">Género</label>
                <select name="genero" id="genero" required>
                    <option value="">Seleccione</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>

                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" required>

                <label for="telefono_personal">Teléfono</label>
                <input type="text" name="telefono_personal" id="telefono_personal" required>

                <label for="email">Correo</label>
                <input type="email" name="email" id="email" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" required>
                
                <!-- Bloque de Asignaturas (Materias y Año y Sección) -->
                <div class="asignaturas-container">
                
                    <div class="asignatura asignatura-createForm">
                        <div class="materia">
                            <label>Asignatura
                                <!-- Se cambia el name para que cada asignatura tenga su propio índice -->
                                <select name="asignaturas[0][id_asignatura]" required>
                                    <option value="">-- Asignatura --</option>
                                    <option value="1">Matemática</option>
                                    <option value="2">Física</option>
                                    <option value="3">Inglés</option>
                                    <option value="4">Biología</option>
                                    <option value="5">Arte y Patrimonio</option>
                                    <option value="6">Química</option>
                                    <option value="7">Orientación y Convivencia</option>
                                    <option value="8">Formación para la Ciudadanía</option>
                                    <option value="9">Historia y Geografía</option>
                                    <option value="10">Grupo de Interés</option>
                                    <option value="11">Castellano y Literatura</option>
                                    <option value="12">Educación Física</option>
                                </select>
                            </label>
                        </div>

                        <div class="anio-seccion">
                            <label>Año y Sección
                                <!-- Se agrupan los checkboxes dentro del mismo índice que la asignatura -->
                                <div class="checkbox-scroll-grid">
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="1"> 1° A</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="2"> 1° B</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="3"> 1° C</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="4"> 2° A</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="5"> 2° B</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="6"> 2° C</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="7"> 3° A</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="8"> 3° B</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="9"> 3° C</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="10"> 4° A</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="11"> 4° B</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="12"> 4° C</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="13"> 5° A</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="14"> 5° B</label>
                                    <label><input type="checkbox" name="asignaturas[0][id_anio_seccion][]" value="15"> 5° C</label>
                                </div>
                            </label>
                        </div>
                        <button type="button" class="remove-button">✖</button>
                    </div>


                    <!-- Se añaden nuevas asignaturas aquí -->

                </div>

                <!-- Botón para agregar una nueva asignatura -->
                <button id="new-asignature" type="button">Agregar otra asignatura</button>


                <div class="form-buttons-wrapper">                    
                    <button type="submit" class="save">Registrar</button>
                    <button id="cancel-create" type="button" class="cancel-create">Cancelar</button>
                </div>


            </form>
        </section>


        <!-- === FORMULARIO PARA EDITAR DOCENTES === -->
        <section class="form-section" id="edit-form-wrapper" style="display: none;">

            <h2 class="form-section__title">Editar docente</h2>
            <!-- === MENSAJE DE ERROR EN EL FORMULARIO === -->

            <form action="editar-docente.php" method="POST" class="form-profesor-edicion">
                <input type="hidden" name="id_docente" id="edit-id">

                <!-- Datos del docente -->
                <label for="edit-cedula">Cédula</label>
                <input type="text" name="cedula" id="edit-cedula" required pattern="\d{7,8}" maxlength="8" title="Debe tener 7 u 8 dígitos numéricos">


                <label for="edit-nombre">Nombres</label>
                <input type="text" name="nombre" id="edit-nombre" required>

                <label for="edit-apellido">Apellidos</label>
                <input type="text" name="apellido" id="edit-apellido" required>

                <label for="edit-fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="edit-fecha_nacimiento" required>

                <label for="edit-genero">Género</label>
                <select name="genero" id="edit-genero" required>
                    <option value="">Seleccione</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>

                <label for="edit-direccion">Dirección</label>
                <input type="text" name="direccion" id="edit-direccion" required>

                <label for="edit-telefono_personal">Teléfono</label>
                <input type="text" name="telefono_personal" id="edit-telefono_personal" required>

                <label for="edit-email">Correo</label>
                <input type="email" name="email" id="edit-email" required>


                <!-- Bloque de Asignaturas (Materias y Año y Sección) -->
                <div class="asignaturas-container">
                
                    <!-- Se cargan las asignaturas aquí -->
                    
                </div>
                
                <!-- Botón para agregar una nueva asignatura -->
                <button id="new-asignature-edition-form" type="button">Agregar otra asignatura</button>

                <div class="form-buttons-wrapper">                    
                    <button type="submit" class="save">Guardar</button>
                    <button id="cancel-edit" type="button" class="cancel">Cancelar</button>
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
    <script src="../../../assets/js/professors-management.js"></script>
</body>
</html>