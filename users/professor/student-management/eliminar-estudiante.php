<?php
// eliminar-estudiante.php
session_start();
require '../../config/data-base.php';

// Validar sesión mínima
if (!isset($_SESSION['rol']) || !isset($_SESSION['id_docente'])) {
    header("Location: student-management.php?error=no_autorizado");
    exit;
}

$rol = $_SESSION['rol'];
$id_docente = intval($_SESSION['id_docente']);

// Validar payload
if (empty($_POST['seleccion']) || !is_array($_POST['seleccion'])) {
    header("Location: student-management.php?error=No seleccionaste ningún registro");
    exit;
}

// Normalizar y filtrar enteros positivos
$raw = $_POST['seleccion'];
$ids = array_values(array_unique(array_map('intval', (array)$raw)));
$ids = array_filter($ids, function($v){ return $v > 0; });
if (count($ids) === 0) {
    header("Location: student-management.php?error=IDs inválidos");
    exit;
}

try {
    if ($rol === 'profesor') {
        // Interpretar $ids como id_periodo_escolar
        $place = implode(',', array_fill(0, count($ids), '?'));
        $sql = "
            SELECT p.id_periodo_escolar AS id_periodo, ea.id_asignatura, ea.id_anio_seccion
            FROM periodo_escolar p
            JOIN estudiante_asignatura_anio_seccion ea ON p.id_estudiante_asignatura = ea.id_estudiante_asignatura
            WHERE p.id_periodo_escolar IN ($place)
        ";
        $stmt = $conexion->prepare($sql);
        $stmt->execute($ids);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            header("Location: student-management.php?error=Periodos no encontrados");
            exit;
        }

        // Validar que el docente tenga la asignatura/anio_seccion correspondiente
        $stmtCheck = $conexion->prepare("
            SELECT 1 FROM docente_asignatura_anio_seccion
            WHERE id_docente = ? AND id_asignatura = ? AND ((id_anio_seccion IS NULL AND ? IS NULL) OR id_anio_seccion = ?)
            LIMIT 1
        ");
        $allowed = [];
        foreach ($rows as $r) {
            $id_periodo = intval($r['id_periodo']);
            $id_asignatura = $r['id_asignatura'];
            $id_anio_seccion = $r['id_anio_seccion']; // puede ser NULL
            $stmtCheck->execute([$id_docente, $id_asignatura, $id_anio_seccion, $id_anio_seccion]);
            if ($stmtCheck->fetchColumn()) {
                $allowed[] = $id_periodo;
            }
        }

        if (empty($allowed)) {
            header("Location: student-management.php?error=no_autorizado");
            exit;
        }

        // Borrar solo los periodos autorizados en transacción
        $conexion->beginTransaction();
        $placeAllowed = implode(',', array_fill(0, count($allowed), '?'));
        // Usamos el nombre real de la columna id_periodo_escolar
        $stmtDel = $conexion->prepare("DELETE FROM periodo_escolar WHERE id_periodo_escolar IN ($placeAllowed)");
        $stmtDel->execute($allowed);
        $conexion->commit();

        header("Location: student-management.php?limpiado=1");
        exit;

    } else {
        // Rol admin u otros: interpretar $ids como id_estudiante y ejecutar eliminación completa
        $place = implode(',', array_fill(0, count($ids), '?'));

        $conexion->beginTransaction();

        // 1) Obtener id_estudiante_asignatura afectados
        $stmtRel = $conexion->prepare("SELECT id_estudiante_asignatura FROM estudiante_asignatura_anio_seccion WHERE id_estudiante IN ($place)");
        $stmtRel->execute($ids);
        $relaciones = $stmtRel->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($relaciones)) {
            $placeRel = implode(',', array_fill(0, count($relaciones), '?'));
            $stmtDelPeriodos = $conexion->prepare("DELETE FROM periodo_escolar WHERE id_estudiante_asignatura IN ($placeRel)");
            $stmtDelPeriodos->execute($relaciones);
        }

        // Eliminar relaciones y estudiantes
        $stmtDelRel = $conexion->prepare("DELETE FROM estudiante_asignatura_anio_seccion WHERE id_estudiante IN ($place)");
        $stmtDelRel->execute($ids);

        $stmtDelEst = $conexion->prepare("DELETE FROM estudiante WHERE id_estudiante IN ($place)");
        $stmtDelEst->execute($ids);

        $conexion->commit();

        header("Location: student-management.php?eliminado=1");
        exit;
    }

} catch (PDOException $e) {
    try { if ($conexion->inTransaction()) $conexion->rollBack(); } catch (Exception $ex) {}
    error_log('eliminar-estudiante error: ' . $e->getMessage());
    header("Location: student-management.php?error=delete_failed");
    exit;
}
?>
