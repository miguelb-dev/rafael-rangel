<?php
// Inicia la sesión para poder usar variables como $_SESSION
session_start();

// Incluye el archivo de conexión a la base de datos
require 'config/data-base.php';

// === Verifica que todos los campos obligatorios estén presentes en el formulario ===
if (
    !empty($_POST['nombre']) &&
    !empty($_POST['apellido']) &&
    !empty($_POST['fecha_nacimiento']) &&
    !empty($_POST['genero']) &&
    !empty($_POST['cedula']) &&
    !empty($_POST['correo']) &&
    !empty($_POST['contrasena']) &&
    !empty($_POST['anio']) &&
    !empty($_POST['seccion'])
) {
    // === Captura los valores clave para validación ===
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];

    // Verifica si ya existe un estudiante con la misma cédula
    $verificarCedula = $conexion->prepare("SELECT id_estudiante FROM estudiante WHERE cedula = ?");
    $verificarCedula->execute([$cedula]);
    $existeCedula = $verificarCedula->fetch(PDO::FETCH_ASSOC);

    // Verifica si ya existe un estudiante con el mismo correo
    $verificarCorreo = $conexion->prepare("SELECT id_estudiante FROM estudiante WHERE email = ?");
    $verificarCorreo->execute([$correo]);
    $existeCorreo = $verificarCorreo->fetch(PDO::FETCH_ASSOC);

    // Si existe alguno, se genera un mensaje específico y se redirige al formulario
    if ($existeCedula || $existeCorreo) {
        if ($existeCedula && $existeCorreo) {
            $_SESSION['mensaje'] = "Ya existe un estudiante con esa <strong>cédula</strong> y <strong>correo</strong>.";
        } elseif ($existeCedula) {
            $_SESSION['mensaje'] = "Ya existe un estudiante con esa <strong>cédula</strong>.";
        } else {
            $_SESSION['mensaje'] = "Ya existe un estudiante con ese <strong>correo</strong>.";
        }

        header('Location: ../public/views/sign-up.php');
        exit;
    }

    // === Captura año y sección para buscar el ID correspondiente ===
    $anio = $_POST['anio'];
    $seccion = $_POST['seccion'];

    // Busca el ID de la combinación año + sección
    $consulta = $conexion->prepare("SELECT id_anio_seccion FROM anio_seccion WHERE anio = ? AND seccion = ?");
    $consulta->execute([$anio, $seccion]);
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    // Si la combinación existe, continúa con el registro
    if ($resultado) {
        $id_anio_seccion = $resultado['id_anio_seccion'];

        // Encripta la contraseña usando password_hash (compatible con PHP 5.5+)
        $contrasena_segura = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

        // === Inserta el nuevo estudiante en la tabla estudiante ===
        $sql = "INSERT INTO estudiante (
            nombre, apellido, fecha_nacimiento, genero, cedula, email, contrasena,
            telefono_personal, telefono_representante, direccion, id_anio_seccion
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $conexion->prepare($sql);
            $exito = $stmt->execute([
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['fecha_nacimiento'],
                $_POST['genero'],
                $cedula,
                $correo,
                $contrasena_segura,
                isset($_POST['telefono_personal']) ? $_POST['telefono_personal'] : null,
                isset($_POST['telefono_representante']) ? $_POST['telefono_representante'] : null,
                isset($_POST['direccion']) ? $_POST['direccion'] : null,
                $id_anio_seccion
            ]);

            // === Si el registro fue exitoso, asigna automáticamente las materias ===
            if ($exito) {
                // Recupera el ID del estudiante recién insertado
                $id_estudiante = $conexion->lastInsertId();

                // Busca todas las asignaturas asociadas al año/sección desde la tabla docente_asignatura_anio_seccion
                $stmtAsignaturas = $conexion->prepare("
                    SELECT DISTINCT id_asignatura
                    FROM docente_asignatura_anio_seccion
                    WHERE id_anio_seccion = ?
                ");
                $stmtAsignaturas->execute([$id_anio_seccion]);
                $asignaturas = $stmtAsignaturas->fetchAll(PDO::FETCH_COLUMN);

                // Inserta la relación para cada asignatura encontrada
                $stmtRelacion = $conexion->prepare("
                    INSERT INTO estudiante_asignatura_anio_seccion (id_estudiante, id_asignatura, id_anio_seccion)
                    VALUES (?, ?, ?)
                ");

                foreach ($asignaturas as $id_asignatura) {
                    $stmtRelacion->execute([$id_estudiante, $id_asignatura, $id_anio_seccion]);
                }

                // Redirige con mensaje de éxito
                $_SESSION['mensaje'] = "Registro exitoso.";
                header('Location: ../public/views/sign-in.php');
                exit;
            }

        } catch (PDOException $e) {
            // Si ocurre un error inesperado, muestra el mensaje real para depuración
            $_SESSION['mensaje'] = "Error inesperado al registrar: " . $e->getMessage();
            header('Location: ../public/views/sign-up.php');
            exit;
        }

    } else {
        // Si la combinación año + sección no existe en la base de datos
        $_SESSION['mensaje'] = "La combinación de año y sección no existe.";
        header('Location: ../public/views/sign-up.php');
        exit;
    }

} else {
    // Si faltan campos obligatorios, se muestra mensaje de advertencia
    $_SESSION['mensaje'] = "Faltan campos obligatorios.";
    header('Location: ../public/views/sign-up.php');
    exit;
}
?>
