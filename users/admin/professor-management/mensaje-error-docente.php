<?php if (isset($_GET['error'])): ?>
    <div class="error-message">
        <?php
        // Captura el tipo de error enviado por GET
        $error = $_GET['error'];

        // Error por cédula duplicada en docente o estudiante
        if ($error === 'cedula_duplicada') {
            echo "Ya existe un docente con esa cédula.";

        // Error por correo duplicado en docente o estudiante
        } elseif ($error === 'correo_duplicado') {
            echo "Ya existe un docente con ese correo.";

        // Error general al registrar el docente
        } elseif ($error === 'docente') {
            echo "Ocurrió un error al registrar el docente.";

        // Error por cédula con longitud inválida
        } elseif ($error === 'cedula_invalida') {
            echo "La cédula debe tener entre 7 y 8 dígitos numéricos.";

        // Error por fecha de nacimiento futura
        } elseif ($error === 'fecha_invalida') {
            echo "La fecha de nacimiento no puede ser mayor a la fecha actual.";
        }
        ?>
    </div>
<?php endif; ?>