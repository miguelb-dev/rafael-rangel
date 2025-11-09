<?php
session_start();

/*
|-------------------------------------------------------------
| Verificación de acceso para administrador
|-------------------------------------------------------------
| Este bloque asegura que:
| 1. El usuario esté logueado (existe 'user_id' en la sesión)
| 2. El rol del usuario sea 'administrador'
| 3. El ID del administrador esté definido
*/

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['id_administrador']) ||
    $_SESSION['rol'] !== 'administrador'
) {
    header('Location: http://localhost/rafael-rangel-main/public/views/sign-in.php');
    exit;
}
?>
