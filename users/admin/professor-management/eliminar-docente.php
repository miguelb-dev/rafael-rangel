<?php
require '../../config/data-base.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (empty($_POST['seleccion']) || !is_array($_POST['seleccion'])) {
    header("Location: professors-management.php?error=No seleccionaste ningún registro");
    exit;
}

$ids = array_map('intval', $_POST['seleccion']);
if (count($ids) === 0) {
    header("Location: professors-management.php?error=No seleccionaste ningún registro");
    exit;
}

try {
    $conexion->beginTransaction();

    // Placeholders
    $place = implode(',', array_fill(0, count($ids), '?'));

    // 1) Eliminar relaciones docente_asignatura_anio_seccion para los docentes seleccionados
    $sqlDelDaas = "DELETE FROM docente_asignatura_anio_seccion WHERE id_docente IN ($place)";
    $stmtDelDaas = $conexion->prepare($sqlDelDaas);
    $stmtDelDaas->execute($ids);

    // 2) Eliminar docentes
    $sqlDelDoc = "DELETE FROM docente WHERE id_docente IN ($place)";
    $stmtDelDoc = $conexion->prepare($sqlDelDoc);
    $stmtDelDoc->execute($ids);

    // 3) Buscar eaas (estudiante_asignatura_anio_seccion) que quedaron huérfanas
    $sqlOrphanEaas = "
        SELECT eaas.id_estudiante_asignatura
        FROM estudiante_asignatura_anio_seccion eaas
        LEFT JOIN docente_asignatura_anio_seccion daas
            ON daas.id_asignatura = eaas.id_asignatura
            AND ( (daas.id_anio_seccion IS NULL AND eaas.id_anio_seccion IS NULL) OR (daas.id_anio_seccion = eaas.id_anio_seccion) )
        WHERE daas.id_docente IS NULL
    ";
    $stmtOrphanEaas = $conexion->query($sqlOrphanEaas);
    $orphanIds = $stmtOrphanEaas->fetchAll(PDO::FETCH_COLUMN);

    if (is_array($orphanIds) && count($orphanIds) > 0) {
        // 4) Eliminar periodos asociados a esas eaas
        $placeOrphans = implode(',', array_fill(0, count($orphanIds), '?'));

        $sqlDelPeriodos = "DELETE FROM periodo_escolar WHERE id_estudiante_asignatura IN ($placeOrphans)";
        $stmtDelPeriodos = $conexion->prepare($sqlDelPeriodos);
        $stmtDelPeriodos->execute($orphanIds);

        // 5) Eliminar las filas huérfanas en eaas
        $sqlDelEaas = "DELETE FROM estudiante_asignatura_anio_seccion WHERE id_estudiante_asignatura IN ($placeOrphans)";
        $stmtDelEaas = $conexion->prepare($sqlDelEaas);
        $stmtDelEaas->execute($orphanIds);
    }

    $conexion->commit();

    header("Location: professors-management.php?eliminado=1");
    exit;

} catch (PDOException $e) {
    try { $conexion->rollBack(); } catch (Exception $inner) {}
    error_log('eliminar-docentes error: '.$e->getMessage());
    header("Location: professors-management.php?error=delete_failed");
    exit;
}
?>
