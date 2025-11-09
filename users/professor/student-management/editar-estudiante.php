<?php
// Conexión a la base de datos
include('../../config/data-base.php');
session_start();


// === Validación inicial ===
if (!isset($_POST['id_estudiante']) || empty($_POST['id_estudiante'])) {
    header("Location: student-management.php?error=estudiante_no_especificado&form=editar");
    exit;
}

if (!isset($_POST['id_estudiante_asignatura']) || empty($_POST['id_estudiante_asignatura'])) {
    header("Location: student-management.php?error=falta_relacion&form=editar");
    exit;
}

$id_estudiante = $_POST['id_estudiante'];
$id_relacion = $_POST['id_estudiante_asignatura'];

// === Función para limpiar valores numéricos ===
function limpiarNumero($valor) {
    return (is_numeric($valor) && $valor !== '') ? $valor : null;
}

// === Captura y limpieza de datos del formulario ===
$nota1 = limpiarNumero($_POST['nota_lapso1']);
$nota2 = limpiarNumero($_POST['nota_lapso2']);
$nota3 = limpiarNumero($_POST['nota_lapso3']);
$inas1 = limpiarNumero($_POST['inasistencia_lapso1']);
$inas2 = limpiarNumero($_POST['inasistencia_lapso2']);
$inas3 = limpiarNumero($_POST['inasistencia_lapso3']);

// === Define el ciclo escolar actual dinámicamente ===
$anio_actual = date('Y');
$mes_actual = date('n');
$ciclo_escolar = ($mes_actual >= 9) ? $anio_actual . '-' . ($anio_actual + 1) : ($anio_actual - 1) . '-' . $anio_actual;




try {
    // === Verificar si ya existe un registro en periodo_escolar ===
    $stmtCheck = $conexion->prepare("
        SELECT id_periodo_escolar 
        FROM periodo_escolar 
        WHERE id_estudiante_asignatura = ?
    ");
    $stmtCheck->execute([$id_relacion]);

    if ($stmtCheck->rowCount() > 0) {
        // === Actualizar notas e inasistencias existentes ===
        $stmtUpdate = $conexion->prepare("
            UPDATE periodo_escolar 
            SET nota_lapso1 = ?, nota_lapso2 = ?, nota_lapso3 = ?, 
                inasistencia_lapso1 = ?, inasistencia_lapso2 = ?, inasistencia_lapso3 = ?
            WHERE id_estudiante_asignatura = ?
        ");
        $stmtUpdate->execute([$nota1, $nota2, $nota3, $inas1, $inas2, $inas3, $id_relacion]);
    } else {
        // === Insertar nuevo registro con ciclo escolar ===
        $stmtInsert = $conexion->prepare("
            INSERT INTO periodo_escolar (
                ciclo_escolar,
                id_estudiante_asignatura,
                nota_lapso1, nota_lapso2, nota_lapso3,
                inasistencia_lapso1, inasistencia_lapso2, inasistencia_lapso3
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtInsert->execute([
            $ciclo_escolar,
            $id_relacion,
            $nota1, $nota2, $nota3,
            $inas1, $inas2, $inas3
        ]);
    }

    // === Redirigir con éxito ===
    header("Location: student-management.php?editado=1");
    exit;

} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
    exit;
}
?>
