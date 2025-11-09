<?php
date_default_timezone_set('America/Caracas');

include('../../config/data-base.php');

// Verifica que el estudiante esté identificado
if (!isset($_SESSION['id_estudiante'])) {
    echo "<tr><td colspan='7' style='color:red;'>Error: estudiante no identificado.</td></tr>";
    exit;
}

$id_estudiante = intval($_SESSION['id_estudiante']);

// Consulta para obtener materias, notas e inasistencias del estudiante
$sql = "
SELECT 
    a.nombre AS nombre_asignatura,
    pe.nota_lapso1,
    pe.nota_lapso2,
    pe.nota_lapso3,
    pe.inasistencia_lapso1,
    pe.inasistencia_lapso2,
    pe.inasistencia_lapso3
FROM estudiante_asignatura_anio_seccion eaas
JOIN asignatura a ON eaas.id_asignatura = a.id_asignatura
LEFT JOIN periodo_escolar pe ON pe.id_estudiante_asignatura = eaas.id_estudiante_asignatura
WHERE eaas.id_estudiante = ?
ORDER BY a.nombre
";

$stmt = $conexion->prepare($sql);
$stmt->execute(array($id_estudiante));
$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$filas) {
    echo "<tr><td colspan='7' style='color:gray;'>No hay calificaciones registradas para este estudiante.</td></tr>";
    exit;
}

foreach ($filas as $fila) {
    $materia = htmlspecialchars($fila['nombre_asignatura']);

    // Calificaciones
    $nota1 = isset($fila['nota_lapso1']) ? intval($fila['nota_lapso1']) : '—';
    $nota2 = isset($fila['nota_lapso2']) ? intval($fila['nota_lapso2']) : '—';
    $nota3 = isset($fila['nota_lapso3']) ? intval($fila['nota_lapso3']) : '—';

    // Inasistencias
    $inas1 = isset($fila['inasistencia_lapso1']) ? intval($fila['inasistencia_lapso1']) : '—';
    $inas2 = isset($fila['inasistencia_lapso2']) ? intval($fila['inasistencia_lapso2']) : '—';
    $inas3 = isset($fila['inasistencia_lapso3']) ? intval($fila['inasistencia_lapso3']) : '—';

    // Clases para calificaciones
    $class1 = is_numeric($nota1) && $nota1 < 10 ? 'failed-grade' : 'passing-grade';
    $class2 = is_numeric($nota2) && $nota2 < 10 ? 'failed-grade' : 'passing-grade';
    $class3 = is_numeric($nota3) && $nota3 < 10 ? 'failed-grade' : 'passing-grade';

    echo "<tr>
        <td>{$materia}</td>
        <td class='{$class1}'>{$nota1}</td>
        <td class='{$class2}'>{$nota2}</td>
        <td class='{$class3}'>{$nota3}</td>
        <td class='absences'>{$inas1}</td>
        <td class='absences'>{$inas2}</td>
        <td class='absences'>{$inas3}</td>
    </tr>";
}
?>
