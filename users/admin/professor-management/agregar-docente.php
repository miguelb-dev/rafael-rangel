<?php
// Conexión a la base de datos
require '../../config/data-base.php';

// Iniciar sesión para posible preservación de datos
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Preservar datos del formulario en sesión si hay error
if (isset($_POST['cedula'])) {
    $_SESSION['form_data'] = $_POST;
}

// Captura de datos del formulario
$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';

if (!preg_match('/^\d{7,8}$/', $cedula)) {
    header("Location: professors-management.php?error=cedula_invalida&form=agregar");
    exit;
}

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';

if (strtotime($fecha_nacimiento) > strtotime(date('Y-m-d'))) {
    header("Location: professors-management.php?error=fecha_invalida&form=agregar");
    exit;
}

$genero = isset($_POST['genero']) ? $_POST['genero'] : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$telefono = isset($_POST['telefono_personal']) ? $_POST['telefono_personal'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$contrasena_raw = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
$contrasena = password_hash($contrasena_raw, PASSWORD_DEFAULT);

try {
    // Iniciar transacción para asegurar consistencia entre tablas
    $conexion->beginTransaction();

    // Validar si la cédula ya existe
    $sql_cedula = "
        SELECT cedula FROM docente WHERE cedula = ?
        UNION
        SELECT cedula FROM estudiante WHERE cedula = ?
    ";
    $stmt_cedula = $conexion->prepare($sql_cedula);
    $stmt_cedula->execute(array($cedula, $cedula));

    if ($stmt_cedula->rowCount() > 0) {
        $conexion->rollBack();
        header("Location: professors-management.php?error=cedula_duplicada&form=agregar");
        exit;
    }

    // Validar si el correo ya existe
    $sql_correo = "
        SELECT email FROM docente WHERE email = ?
        UNION
        SELECT email FROM estudiante WHERE email = ?
    ";
    $stmt_correo = $conexion->prepare($sql_correo);
    $stmt_correo->execute(array($email, $email));

    if ($stmt_correo->rowCount() > 0) {
        $conexion->rollBack();
        header("Location: professors-management.php?error=correo_duplicado&form=agregar");
        exit;
    }

    // Insertar nuevo docente
    $sql_docente = "INSERT INTO docente (
        cedula, nombre, apellido, fecha_nacimiento, genero,
        direccion, telefono_personal, email, contrasena
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql_docente);
    $stmt->execute(array($cedula, $nombre, $apellido, $fecha_nacimiento, $genero, $direccion, $telefono, $email, $contrasena));

    $id_docente = $conexion->lastInsertId();

    // Procesar asignaciones (código existente)
    $asignaciones = isset($_POST['asignaturas']) ? $_POST['asignaturas'] : array();

    $insertedDaas = array(); // guardar pares insertados "id_asignatura|id_anio_seccion"

    if (!empty($asignaciones)) {
        $check_asignatura = $conexion->prepare("SELECT id_asignatura FROM asignatura WHERE id_asignatura = ?");
        $check_anio = $conexion->prepare("SELECT id_anio_seccion FROM anio_seccion WHERE id_anio_seccion = ?");
        $insert_relacion = $conexion->prepare("INSERT INTO docente_asignatura_anio_seccion (
            id_docente, id_asignatura, id_anio_seccion
        ) VALUES (?, ?, ?)");

        foreach ($asignaciones as $bloque) {
            $id_asignatura = isset($bloque['id_asignatura']) ? $bloque['id_asignatura'] : '';
            $id_anios = isset($bloque['id_anio_seccion']) ? $bloque['id_anio_seccion'] : array();

            $check_asignatura->execute(array($id_asignatura));
            if ($check_asignatura->rowCount() > 0) {
                foreach ($id_anios as $id_anio_seccion) {
                    $check_anio->execute(array($id_anio_seccion));
                    if ($check_anio->rowCount() > 0) {
                        $insert_relacion->execute(array($id_docente, $id_asignatura, $id_anio_seccion));
                        // normalizar cadena para NULL/valor
                        $key = $id_asignatura . '|' . (is_null($id_anio_seccion) ? '' : $id_anio_seccion);
                        $insertedDaas[$key] = $key;
                    }
                }
            }
        }
    }

    // === SINCRONIZAR eaas: crear asignaciones de estudiantes faltantes para las nuevas daas ===
    // Solo para los daas que acabamos de insertar (insertedDaas)
    if (!empty($insertedDaas)) {
        // Preparar sentencias reutilizables
        $stmtFindStudents = $conexion->prepare("SELECT id_estudiante FROM estudiante WHERE id_anio_seccion = ?");
        $stmtCheckEaas = $conexion->prepare("SELECT 1 FROM estudiante_asignatura_anio_seccion WHERE id_estudiante = ? AND id_asignatura = ? AND (id_anio_seccion = ? OR (id_anio_seccion IS NULL AND ? IS NULL)) LIMIT 1");
        $stmtInsertEaas = $conexion->prepare("INSERT INTO estudiante_asignatura_anio_seccion (id_estudiante, id_asignatura, id_anio_seccion) VALUES (?, ?, ?)");

        foreach ($insertedDaas as $pair) {
            $parts = explode('|', $pair);
            $aId = isset($parts[0]) ? $parts[0] : '';
            $sId = isset($parts[1]) ? $parts[1] : '';
            $id_asignatura = $aId;
            $id_anio_seccion = ($sId === '') ? null : $sId;

            if ($id_anio_seccion === null) {
                // Política actual: no crear eaas para daas con id_anio_seccion NULL
                continue;
            }

            // Obtener estudiantes que pertenecen a esa anio_seccion
            $stmtFindStudents->execute(array($id_anio_seccion));
            $students = $stmtFindStudents->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($students)) {
                foreach ($students as $id_estudiante_row) {
                    // Verificar si ya existe la fila eaas para este estudiante+asignatura+seccion
                    $stmtCheckEaas->execute(array($id_estudiante_row, $id_asignatura, $id_anio_seccion, $id_anio_seccion));
                    $exists = $stmtCheckEaas->fetchColumn();
                    if (!$exists) {
                        $stmtInsertEaas->execute(array($id_estudiante_row, $id_asignatura, $id_anio_seccion));
                    }
                }
            }
        }
    }

    // Confirmar transacción
    $conexion->commit();

    // Limpiar datos de sesión en éxito
    unset($_SESSION['form_data']);
    header("Location: professors-management.php");
    exit;

} catch (PDOException $e) {
    try { $conexion->rollBack(); } catch (Exception $inner) {}
    header("Location: professors-management.php?error=docente&form=agregar");
    exit;
}
?>
