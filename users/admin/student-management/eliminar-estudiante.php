<?php
include('../../config/data-base.php');

if (!empty($_POST['seleccion'])) {
    $ids = $_POST['seleccion']; // array de IDs de estudiantes seleccionados

    // Construir placeholders (?, ?, ?, ...)
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    // Paso 1: Buscar todas las claves de relación estudiante-asignatura
    $sql1 = "SELECT id_estudiante_asignatura FROM estudiante_asignatura_anio_seccion WHERE id_estudiante IN ($placeholders)";
    $stmt1 = $conexion->prepare($sql1);
    $stmt1->execute($ids);
    $relaciones = $stmt1->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($relaciones)) {
        // Paso 2: Eliminar registros en periodo_escolar
        $placeholdersRel = implode(',', array_fill(0, count($relaciones), '?'));
        $sql2 = "DELETE FROM periodo_escolar WHERE id_estudiante_asignatura IN ($placeholdersRel)";
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->execute($relaciones);
    }

    // Paso 3: Eliminar relaciones en estudiante_asignatura_anio_seccion
    $sql3 = "DELETE FROM estudiante_asignatura_anio_seccion WHERE id_estudiante IN ($placeholders)";
    $stmt3 = $conexion->prepare($sql3);
    $stmt3->execute($ids);

    // Paso 4: Eliminar estudiantes
    $sql4 = "DELETE FROM estudiante WHERE id_estudiante IN ($placeholders)";
    $stmt4 = $conexion->prepare($sql4);
    $stmt4->execute($ids);

    // Redirigir con mensaje de éxito
    header("Location: student-management.php?eliminado=1");
    exit;
} else {
    // Si no se seleccionó nada
    header("Location: student-management.php?error=No seleccionaste ningún registro");
    exit;
}
?>
