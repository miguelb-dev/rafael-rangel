<?php
// Inicia la sesión para poder acceder a las variables de $_SESSION
session_start();

/*
|-------------------------------------------------------------
| Verificación de acceso
|-------------------------------------------------------------
| Este bloque asegura que:
| 1. El usuario esté logueado (existe 'user_id' en la sesión)
| 2. El rol del usuario sea 'profesor'
| 3. El ID del docente esté definido (necesario para el CRUD)
|
| Si alguna de estas condiciones falla, se redirige al login.
*/

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['id_docente']) ||
    $_SESSION['rol'] !== 'profesor'
) {
    // Redirige al formulario de inicio de sesión si no cumple
    header('Location: http://localhost/rafael-rangel-main/public/views/sign-in.php');
    exit;
}
?>
