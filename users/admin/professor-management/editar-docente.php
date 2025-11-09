<?php
// Conexión a la base de datos
include('../../config/data-base.php');

// Iniciar sesión para preservar estado
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Verificar que se recibió el ID del docente
if (!isset($_POST['id_docente'])) {
    header("Location: professors-management.php?error=Docente no especificado&form=editar");
    exit;
}

// Capturar datos del formulario
$id = $_POST['id_docente'];
$cedula = $_POST['cedula'];

// Validación de cédula: debe tener 7 u 8 dígitos numéricos
if (!preg_match('/^\d{7,8}$/', $cedula)) {
    header("Location: professors-management.php?error=cedula_invalida&form=editar");
    exit;
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono_personal'];
$direccion = $_POST['direccion'];
$genero = $_POST['genero'];
$fecha = $_POST['fecha_nacimiento'];

// Validación: la fecha no puede ser mayor a hoy
if (strtotime($fecha) > strtotime(date('Y-m-d'))) {
    header("Location: professors-management.php?error=fecha_invalida&form=editar");
    exit;
}

// Capturar estructura agrupada de asignaciones
$bloques = isset($_POST['asignaturas']) ? $_POST['asignaturas'] : array();

try {
    // Iniciar transacción para agrupar toda la operación
    $conexion->beginTransaction();

    // Validar si la cédula ya existe en otro docente o estudiante
    $sql_cedula = "
        SELECT cedula FROM docente WHERE cedula = ? AND id_docente != ?
        UNION
        SELECT cedula FROM estudiante WHERE cedula = ?
    ";
    $stmt_cedula = $conexion->prepare($sql_cedula);
    $stmt_cedula->execute(array($cedula, $id, $cedula));

    if ($stmt_cedula->rowCount() > 0) {
        $conexion->rollBack();
        header("Location: professors-management.php?error=cedula_duplicada&form=editar");
        exit;
    }

    // Validar si el correo ya existe en otro docente o estudiante
    $sql_correo = "
        SELECT email FROM docente WHERE email = ? AND id_docente != ?
        UNION
        SELECT email FROM estudiante WHERE email = ?
    ";
    $stmt_correo = $conexion->prepare($sql_correo);
    $stmt_correo->execute(array($email, $id, $email));

    if ($stmt_correo->rowCount() > 0) {
        $conexion->rollBack();
        header("Location: professors-management.php?error=correo_duplicado&form=editar");
        exit;
    }

    // Actualizar los datos del docente
    $sql = "UPDATE docente 
            SET cedula = ?, nombre = ?, apellido = ?, email = ?, telefono_personal = ?, direccion = ?, genero = ?, fecha_nacimiento = ?
            WHERE id_docente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(array($cedula, $nombre, $apellido, $email, $telefono, $direccion, $genero, $fecha, $id));

    // --- Guardar en memoria las nuevas asignaciones que vamos a insertar ---
    $newAssignments = array(); // array of "id_asignatura|id_anio_seccion"
    foreach ($bloques as $bloque) {
        $id_asignatura = isset($bloque['id_asignatura']) ? $bloque['id_asignatura'] : '';
        $id_anios = isset($bloque['id_anio_seccion']) ? $bloque['id_anio_seccion'] : array();
        if ($id_asignatura === '') continue;
        foreach ($id_anios as $id_anio_seccion) {
            // normalizar cadena (usar vacío para NULL)
            $newAssignments[] = $id_asignatura . '|' . (is_null($id_anio_seccion) ? '' : $id_anio_seccion);
        }
    }

    // Eliminar todas las asignaciones anteriores del docente
    $delStmt = $conexion->prepare("DELETE FROM docente_asignatura_anio_seccion WHERE id_docente = ?");
    $delStmt->execute(array($id));

    // Insertar nuevas asignaciones por bloque
    $stmtInsert = $conexion->prepare("INSERT INTO docente_asignatura_anio_seccion (id_docente, id_asignatura, id_anio_seccion) VALUES (?, ?, ?)");

    foreach ($bloques as $bloque) {
        $id_asignatura = isset($bloque['id_asignatura']) ? $bloque['id_asignatura'] : '';
        $id_anios = isset($bloque['id_anio_seccion']) ? $bloque['id_anio_seccion'] : array();

        // Validar que la asignatura exista
        $check_asignatura = $conexion->prepare("SELECT id_asignatura FROM asignatura WHERE id_asignatura = ?");
        $check_asignatura->execute(array($id_asignatura));

        if ($check_asignatura->rowCount() > 0) {
            foreach ($id_anios as $id_anio_seccion) {
                // Validar que el año/sección exista
                $check_anio = $conexion->prepare("SELECT id_anio_seccion FROM anio_seccion WHERE id_anio_seccion = ?");
                $check_anio->execute(array($id_anio_seccion));

                if ($check_anio->rowCount() > 0) {
                    $stmtInsert->execute(array($id, $id_asignatura, $id_anio_seccion));
                }
            }
        }
    }

    // === SINCRONIZAR eaas: crear asignaciones de estudiantes faltantes para las nuevas daas ===
    // Coloca esto después de los INSERT en docente_asignatura_anio_seccion y antes de $conexion->commit();
    if (!empty($newAssignments)) {
        // Preparar sentencias reutilizables
        $stmtFindStudents = $conexion->prepare("SELECT id_estudiante FROM estudiante WHERE id_anio_seccion = ?");
        $stmtCheckEaas = $conexion->prepare("SELECT 1 FROM estudiante_asignatura_anio_seccion WHERE id_estudiante = ? AND id_asignatura = ? AND (id_anio_seccion = ? OR (id_anio_seccion IS NULL AND ? IS NULL)) LIMIT 1");
        $stmtInsertEaas = $conexion->prepare("INSERT INTO estudiante_asignatura_anio_seccion (id_estudiante, id_asignatura, id_anio_seccion) VALUES (?, ?, ?)");

        foreach ($newAssignments as $pair) {
            $parts = explode('|', $pair);
            $aId = isset($parts[0]) ? $parts[0] : '';
            $sId = isset($parts[1]) ? $parts[1] : '';
            $id_asignatura = $aId;
            $id_anio_seccion = ($sId === '') ? null : $sId;

            // Obtener estudiantes que pertenecen a ese anio_seccion (si id_anio_seccion es NULL se omite)
            if ($id_anio_seccion === null) {
                // Si la relación daas indica NULL y se desea crear eaas con NULL, cambiar política aquí.
                continue;
            } else {
                // Obtener todos los estudiantes asignados a esa anio_seccion
                $stmtFindStudents->execute(array($id_anio_seccion));
                $students = $stmtFindStudents->fetchAll(PDO::FETCH_COLUMN);
            }

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

    // === NUEVO: limpiar filas huérfanas en estudiante_asignatura_anio_seccion
    // Estrategia:
    // 1) Buscar todas las filas de estudiante_asignatura_anio_seccion (eaas) cuyo par (id_asignatura,id_anio_seccion)
    //    NO tenga actualmente una fila en docente_asignatura_anio_seccion (es decir, quedaron huérfanas).
    // 2) Para esas eaas: eliminar primero cualquier fila en periodo_escolar que las referencie.
    // 3) Luego eliminar las filas eaas.
    //
    // Nota: actuamos sobre todas las huérfanas globalmente (no solo del docente), porque al cambiar asignaciones
    // se crean/quitan relaciones en docente_asignatura_anio_seccion que afectan a eaas.

    // 1) obtener ids de eaas huérfanos
    $sqlOrphan = "
        SELECT eaas.id_estudiante_asignatura
        FROM estudiante_asignatura_anio_seccion eaas
        LEFT JOIN docente_asignatura_anio_seccion daas
            ON daas.id_asignatura = eaas.id_asignatura
            AND daas.id_anio_seccion = eaas.id_anio_seccion
        WHERE daas.id_docente IS NULL
    ";
    $stmtOrphan = $conexion->query($sqlOrphan);
    $orphanIds = $stmtOrphan->fetchAll(PDO::FETCH_COLUMN);

    if (is_array($orphanIds) && count($orphanIds) > 0) {
        $place = implode(',', array_fill(0, count($orphanIds), '?'));

        // Eliminar periodos que referencien esas filas (primero los periodos)
        $sqlDeletePeriodos = "DELETE FROM periodo_escolar WHERE id_estudiante_asignatura IN ($place)";
        $stmtDeletePeriodos = $conexion->prepare($sqlDeletePeriodos);
        $stmtDeletePeriodos->execute($orphanIds);

        // Eliminar las filas huérfanas en eaas
        $sqlDeleteEaas = "DELETE FROM estudiante_asignatura_anio_seccion WHERE id_estudiante_asignatura IN ($place)";
        $stmtDeleteEaas = $conexion->prepare($sqlDeleteEaas);
        $stmtDeleteEaas->execute($orphanIds);
    }

    // Confirmar transacción
    $conexion->commit();

    // Limpiar datos de sesión en éxito
    unset($_SESSION['form_data']);

    // Redirigir con éxito
    header("Location: professors-management.php?editado=1");
    exit;

} catch (PDOException $e) {
    try { $conexion->rollBack(); } catch (Exception $inner) {}
    header("Location: professors-management.php?error=docente&form=editar");
    exit;
}
?>
