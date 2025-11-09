<?php 
session_start(); // Inicia la sesión para poder usar $_SESSION['mensaje']
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Iniciar Sesión</title>

    <link rel="stylesheet" href="../../assets/css/font.css">
    <link rel="stylesheet" href="../../assets/css/sign-in-styles.css">
    <link rel="icon" href="../../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="layout">
        <main>

        <?php
        // Si hay un mensaje guardado en la sesión (por error o éxito), se muestra y luego se elimina
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='error-message'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']);
        }
        ?>

        <form class="sign-in" method="POST" action="../../users/sign-in.php">
            <header class="sign-in__header">
                <img class="header__logo" src="../../assets/img/favicon.png" alt="Logo del Complejo Educativo Rafael Rangel">
                <h1 class="header__title">Iniciar sesión</h1>
                <a class="header__link" href="../../index.php">Volver al inicio</a>
            </header>

            <div class="sign-in__inputs-container">

                <label for="correo">Correo</label>
                <div class="input-group">
                    <i class="fa-solid fa-envelope input__icon"></i>
                    <input id="correo" name="correo" class="input__field" type="email" required>
                </div>

                <label for="password">Contraseña</label>
                <div class="password-wrapper">
                    <i class="fa-solid fa-lock input__icon"></i>
                    <input id="password" name="contrasena" class="input__field" type="password" required>
                    <i class="password-eye fa-solid fa-eye-slash"></i>
                </div>

                <label class="remember-me">
                    <input id="remember-me" type="checkbox"> Recordarme
                </label>
            </div>

            <button type="submit">Iniciar Sesión</button>

            <div class="sign-up-wrapper">
                <p class="sign-up__message">¿No tienes una cuenta?</p>
                <a class="sign-up__link" href="sign-up.php">Crea una</a>
            </div>
        </form>
        </main>
    </div>

    <script src="../../assets/js/password-eye.js"></script>
    <script src="../../assets/js/sign-in.js"></script>
</body>
</html>
