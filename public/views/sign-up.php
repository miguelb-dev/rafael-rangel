<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Crear una cuenta</title>
    
    <link rel="stylesheet" href="../../assets/css/font.css">
    <link rel="stylesheet" href="../../assets/css/sign-up-styles.css">
    <link rel="icon" href="../../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="layout">
        <main>

            <?php
            session_start();
            if (isset($_SESSION['mensaje'])) {
                echo "<div class='error-message'>" . $_SESSION['mensaje'] . "</div>";
                unset($_SESSION['mensaje']);
            }
            ?>


            <!-- === VENTANA DE DIALOGO === -->
            <section class="dialog-window">
                <header class="dialog-window__header">
                    <h2 class="dialog__title">¿Eres estudiante o docente?</h2>
                    <a class="dialog__link" href="../../index.php">Volver al inicio</a>
                </header>

                <div class="buttons-wrapper">
                    <button id="student-button" type="button">Soy estudiante</button>
                    <button id="professor-button" type="button">Soy docente</button>
                </div>
            </section>
            
            
            <!-- === FORMULARIO DE REGISTRO === -->
            <!-- Aquí intenté usar un codigo php en el style pero no logré que funcionara -->
            <form class="sign-up" method="POST" action="../../users/sign-up.php" style="display: none;">
                <header class="sign-up__header">
                    <img class="header__logo" src="../../assets/img/favicon.png" alt="Logo del Complejo Educativo Rafael Rangel">
                    <h1 class="header__title">Crear una cuenta</h1>
                    <a class="header__link" href="../../index.php">Volver al inicio</a>
                </header>

                <div class="sign-up__inputs-container">
                    <!-- Campos personales -->
                    <label for="first-name">Nombres</label>
                    <input id="first-name" name="nombre" class="input__field" type="text" required>

                    <label for="last-name">Apellidos</label>
                    <input id="last-name" name="apellido" class="input__field" type="text" required>

                    <label for="birthdate">Fecha de nacimiento</label>
                    <input id="birthdate" name="fecha_nacimiento" type="date" max="2" class="input__field" required>

                    <!-- Género -->
                    <p class="gender-indication">Género</p>
                    <div class="gender__wrapper">
                        <div class="gender__option">
                            <input id="male" name="genero" type="radio" value="Masculino" required>
                            <label for="male">Hombre</label>
                        </div>
                        <div class="gender__option">
                            <input id="female" name="genero" type="radio" value="Femenino" required>
                            <label for="female">Mujer</label>
                        </div>
                    </div>

                    <!-- Identificación -->
                    <label for="cedula">Número de cédula</label>
                    <input id="cedula" name="cedula" class="input__field" type="number" inputmode="numeric" pattern="\d+" required>
                    
                    <label for="correo">Correo</label>
                    <input id="correo" name="correo" class="input__field" type="email" required>

                    <!-- Contraseña -->
                    <label for="password">Contraseña</label>
                    <div class="password-wrapper">
                        <input id="password" name="contrasena" class="input__field" type="password" required>
                        <i class="password-eye fa-solid fa-eye-slash"></i>
                    </div>

                    <!-- Año y sección -->
                    <div class="anio-seccion-wrapper" style="display: flex; gap: 20px;">
                        <div class="anio-wrapper">
                            <label for="anio">Año</label>
                            <select id="anio" name="anio" class="input__field" required>
                                <option value="">Seleccione año</option>
                                <option value="1">1er Año</option>
                                <option value="2">2do Año</option>
                                <option value="3">3er Año</option>
                                <option value="4">4to Año</option>
                                <option value="5">5to Año</option>
                            </select>
                        </div>
                        <div class="seccion-wrapper">
                            <label for="seccion">Sección</label>
                            <select id="seccion" name="seccion" class="input__field" required>
                                <option value="">Seleccione sección</option>
                                <option value="A">Sección A</option>
                                <option value="B">Sección B</option>
                                <option value="C">Sección C</option>
                            </select>
                        </div>
                    </div>


                    <!-- Teléfonos y dirección -->
                    <label for="telephone">Teléfono</label>
                    <input id="telephone" name="telefono_personal" class="input__field" type="tel" inputmode="numeric" pattern="\d+" required>

                    <label for="father-telephone">Teléfono del representante</label>
                    <input id="father-telephone" name="telefono_representante" class="input__field" type="tel">

                    <label for="direccion">Dirección</label>
                    <input id="direccion" name="direccion" class="input__field" type="text">
                </div>

                <button class="form-button" type="submit">Registrarse</button>

                <div class="sign-in-wrapper">
                    <p class="sign-in__message">¿Ya tienes una cuenta?</p>
                    <a class="sign-in__link" href="sign-in.php">Inicia sesión</a>
                </div>
            </form>


            <!-- === MENSAJE PARA EL DOCENTE === -->
            <section class="professor-message" style="display: none;">
                <header class="professor-message__header">
                    <h2 class="professor__title">Cómo ingresar en nuestra aplicación como Docente</h2>
                    <a class="professor__link" href="../../index.php">Volver al inicio</a>
                </header>
                <div class="professor-message__description">
                    <p>Si usted es un Docente, para poder ingresar en nuestra plataforma, necesita que el admnistrador le asigne una cuenta como Docente, para ello, deberá seguir los siguentes pasos:</p>
                    <ul>
                        <li>Tendrá que enviar un correo electrónico con su informacion de contacto (N° de cédula, nombre, apellido, correo electrónico, N° de teléfono, dirección y fecha de nacimiento) junto con su explicación de que desea ingresar en nuestra plataforma como Docente, al correo:  <em>soporterafaelrangel@gmail.com</em>.</li>
                        <li>Tendrá que esperar un periodo máximo de 5 días para que un administrador apruebe su solicitud.</li>
                        <li>En caso de ser aprobado/desaprobado, se le notificará con un correo de confirmación/negación.</li>
                        <li>Si supera el periodo de espera y no recibe ninguna respuesta, se recomienda dirigirse personalmente a la institución.</li>
                    </ul>
                </div>
            </section>


        </main>
    </div>
    
    <script src="../../assets/js/password-eye.js"></script>
    <script src="../../assets/js/sign-up.js"></script>
</body>
</html>
