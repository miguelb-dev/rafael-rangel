<?php
// Inicia la sesión para poder acceder a las variables de $_SESSION
session_start();

/*
|-------------------------------------------------------------
| Verificación de acceso
|-------------------------------------------------------------
| Este bloque asegura que:
| 1. El usuario esté logueado (existe 'user_id' en la sesión)
| 2. El rol del usuario sea 'estudiante'
|
| Si alguna de estas condiciones falla, se redirige al login.
| Esto protege archivos exclusivos para estudiantes.
*/

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'estudiante') {
    // Redirige al formulario de inicio de sesión si no cumple
    // se utilizó una ruta absoluta porque una relativa no era  reconocida por el navegador
    header('Location: http://localhost/rafael-rangel-main/public/views/sign-in.php');
    exit;
}
?>
