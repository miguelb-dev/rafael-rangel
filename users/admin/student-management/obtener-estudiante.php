<?php
date_default_timezone_set('America/Caracas');
include('../../config/data-base.php');

// === Captura de filtros desde GET ===
$materia = isset($_GET['materia']) ? trim($_GET['materia']) : '';
$id_anio_seccion = isset($_GET['anio_seccion']) ? intval($_GET['anio_seccion']) : 0;

// === SINCRONIZACIÓN GLOBAL: asignar nuevas materias a estudiantes en todas secciones activas ===
$sqlSecciones = "SELECT DISTINCT id_anio_seccion FROM docente_asignatura_anio_seccion";
$stmtSecciones = $conexion->query($sqlSecciones);
$secciones = $stmtSecciones->fetchAll(PDO::FETCH_COLUMN);

foreach ($secciones as $id_seccion) {
    // NUEVO: Obtener estudiantes desde la tabla estudiante (fuente canónica de pertenencia a sección)
    $sqlEstudiantes = "
        SELECT id_estudiante FROM estudiante
        WHERE id_anio_seccion = ?
        GROUP BY id_estudiante
    ";
    $stmtEstudiantes = $conexion->prepare($sqlEstudiantes);
    $stmtEstudiantes->execute(array($id_seccion));
    $estudiantes = $stmtEstudiantes->fetchAll(PDO::FETCH_COLUMN);

    // Materias asignadas por profesores en esa sección
    $sqlMaterias = "
        SELECT id_asignatura FROM docente_asignatura_anio_seccion
        WHERE id_anio_seccion = ?
    ";
    $stmtMaterias = $conexion->prepare($sqlMaterias);
    $stmtMaterias->execute(array($id_seccion));
    $materias = $stmtMaterias->fetchAll(PDO::FETCH_COLUMN);

    foreach ($estudiantes as $id_estudiante) {
        foreach ($materias as $id_asignatura) {
            $verificar = $conexion->prepare("
                SELECT COUNT(*) FROM estudiante_asignatura_anio_seccion
                WHERE id_estudiante = ? AND id_asignatura = ? AND id_anio_seccion = ?
            ");
            $verificar->execute(array($id_estudiante, $id_asignatura, $id_seccion));
            $existe = $verificar->fetchColumn();

            if (!$existe) {
                $insertar = $conexion->prepare("
                    INSERT INTO estudiante_asignatura_anio_seccion (id_estudiante, id_asignatura, id_anio_seccion)
                    VALUES (?, ?, ?)
                ");
                $insertar->execute(array($id_estudiante, $id_asignatura, $id_seccion));
            }
        }
    }
}

// === LIMPIEZA DE FILAS HUÉRFANAS EN estudiante_asignatura_anio_seccion ===
// NUEVO: eliminar filas en estudiante_asignatura_anio_seccion que ya no tienen docente asociado
// pero solo si no existen periodos (para no perder notas). Hacemos esto en transacción por seguridad.

try {
    $conexion->beginTransaction();

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
        $placeholders = implode(',', array_fill(0, count($orphanIds), '?'));

        $sqlHasPeriodo = "
            SELECT DISTINCT pe.id_estudiante_asignatura
            FROM periodo_escolar pe
            WHERE pe.id_estudiante_asignatura IN ($placeholders)
        ";
        $stmtHasPeriodo = $conexion->prepare($sqlHasPeriodo);
        $stmtHasPeriodo->execute($orphanIds);
        $withPeriodo = $stmtHasPeriodo->fetchAll(PDO::FETCH_COLUMN);

        $idsToDelete = array();
        foreach ($orphanIds as $id) {
            if (!in_array($id, $withPeriodo)) {
                $idsToDelete[] = $id;
            }
        }

        if (count($idsToDelete) > 0) {
            $placeDel = implode(',', array_fill(0, count($idsToDelete), '?'));
            $sqlDelete = "DELETE FROM estudiante_asignatura_anio_seccion WHERE id_estudiante_asignatura IN ($placeDel)";
            $stmtDelete = $conexion->prepare($sqlDelete);
            $stmtDelete->execute($idsToDelete);
        }
    }

    $conexion->commit();

} catch (PDOException $e) {
    try { $conexion->rollBack(); } catch (Exception $inner) {}
    error_log('Error limpieza huérfanas: ' . $e->getMessage());
}

// === Construcción dinámica del WHERE ===
$where = array();
if ($materia !== '') {
    $where[] = "a.nombre = " . $conexion->quote($materia);
}
if ($id_anio_seccion > 0) {
    $where[] = "an_final.id_anio_seccion = " . intval($id_anio_seccion);
}
$condicion = count($where) > 0 ? " AND " . implode(" AND ", $where) : "";

// === Consulta principal ===
// NUEVO: incluir filas válidas, estudiantes sin asignación, y filas huérfanas (se muestran como 'No asignada')
$sql = "
SELECT 
    e.id_estudiante,
    eaas.id_estudiante_asignatura,
    e.cedula,
    e.nombre AS nombre_estudiante,
    e.apellido,
    an_final.anio AS anio,
    an_final.seccion AS seccion,
    a.nombre AS nombre_asignatura,
    eaas.id_asignatura,
    eaas.id_anio_seccion,
    pe.nota_lapso1,
    pe.nota_lapso2,
    pe.nota_lapso3,
    pe.inasistencia_lapso1,
    pe.inasistencia_lapso2,
    pe.inasistencia_lapso3,
    (SELECT COUNT(*) FROM docente_asignatura_anio_seccion daas
WHERE daas.id_asignatura = eaas.id_asignatura
AND daas.id_anio_seccion = eaas.id_anio_seccion
    ) AS tiene_docente
FROM estudiante e
LEFT JOIN estudiante_asignatura_anio_seccion eaas ON e.id_estudiante = eaas.id_estudiante
LEFT JOIN anio_seccion an_asig ON eaas.id_anio_seccion = an_asig.id_anio_seccion
LEFT JOIN anio_seccion an_est ON e.id_anio_seccion IS NOT NULL AND e.id_anio_seccion = an_est.id_anio_seccion
LEFT JOIN anio_seccion an_final ON an_final.id_anio_seccion = (
    CASE
        WHEN an_asig.id_anio_seccion IS NOT NULL THEN an_asig.id_anio_seccion
        WHEN e.id_anio_seccion IS NOT NULL THEN e.id_anio_seccion
        ELSE NULL
    END
)
LEFT JOIN asignatura a ON eaas.id_asignatura = a.id_asignatura
LEFT JOIN periodo_escolar pe ON pe.id_estudiante_asignatura = eaas.id_estudiante_asignatura
WHERE (
    (eaas.id_estudiante_asignatura IS NOT NULL AND (SELECT COUNT(*) FROM docente_asignatura_anio_seccion daas WHERE daas.id_asignatura = eaas.id_asignatura AND daas.id_anio_seccion = eaas.id_anio_seccion) > 0)
    OR eaas.id_estudiante_asignatura IS NULL
    OR (eaas.id_estudiante_asignatura IS NOT NULL AND (SELECT COUNT(*) FROM docente_asignatura_anio_seccion daas2 WHERE daas2.id_asignatura = eaas.id_asignatura AND daas2.id_anio_seccion = eaas.id_anio_seccion) = 0)
)
$condicion
ORDER BY an_final.anio, an_final.seccion, a.nombre, e.cedula
";

try {
    $consulta = $conexion->query($sql);

    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $tiene_docente = isset($fila['tiene_docente']) ? intval($fila['tiene_docente']) : 0;

        if (!isset($fila['nombre_asignatura']) || $fila['nombre_asignatura'] === '' || $tiene_docente === 0) {
            $nombreAsignaturaMostrar = 'No asignada';
            $data_id_asignatura = '';
            $data_id_anio_seccion = '';
            $data_id_estudiante_asignatura = '';
            $data_nota1 = '';
            $data_nota2 = '';
            $data_nota3 = '';
            $data_inas1 = '';
            $data_inas2 = '';
            $data_inas3 = '';
        } else {
            $nombreAsignaturaMostrar = $fila['nombre_asignatura'];
            $data_id_asignatura = isset($fila['id_asignatura']) ? $fila['id_asignatura'] : '';
            $data_id_anio_seccion = isset($fila['id_anio_seccion']) ? $fila['id_anio_seccion'] : '';
            $data_id_estudiante_asignatura = isset($fila['id_estudiante_asignatura']) ? $fila['id_estudiante_asignatura'] : '';
            $data_nota1 = isset($fila['nota_lapso1']) ? $fila['nota_lapso1'] : '';
            $data_nota2 = isset($fila['nota_lapso2']) ? $fila['nota_lapso2'] : '';
            $data_nota3 = isset($fila['nota_lapso3']) ? $fila['nota_lapso3'] : '';
            $data_inas1 = isset($fila['inasistencia_lapso1']) ? $fila['inasistencia_lapso1'] : '';
            $data_inas2 = isset($fila['inasistencia_lapso2']) ? $fila['inasistencia_lapso2'] : '';
            $data_inas3 = isset($fila['inasistencia_lapso3']) ? $fila['inasistencia_lapso3'] : '';
        }

        $mostrarAnio = (isset($fila['anio']) && $fila['anio'] !== null && $fila['anio'] !== '') ? $fila['anio'] . "° Año" : '—';
        $mostrarSeccion = (isset($fila['seccion']) && $fila['seccion'] !== null && $fila['seccion'] !== '') ? $fila['seccion'] : '—';

        echo '<tr>';
        echo '<td class="seleccion-edicion" style="display: none;"><input type="radio" name="estudiante_editar"></td>';
        echo '<td class="seleccion-col" style="display: none;"><input type="checkbox" name="seleccion[]" value="' . $fila['id_estudiante'] . '"></td>';
        echo '<td style="display:none;">';
        echo '<button type="button" class="edit-btn"'
            . ' data-id_estudiante="' . $fila['id_estudiante'] . '"'
            . ' data-cedula="' . $fila['cedula'] . '"'
            . ' data-nombre="' . $fila['nombre_estudiante'] . '"'
            . ' data-apellido="' . $fila['apellido'] . '"'
            . ' data-asignatura="' . htmlspecialchars($nombreAsignaturaMostrar, ENT_QUOTES, 'UTF-8') . '"'
            . ' data-id_asignatura="' . $data_id_asignatura . '"'
            . ' data-id_anio_seccion="' . $data_id_anio_seccion . '"'
            . ' data-id_estudiante_asignatura="' . $data_id_estudiante_asignatura . '"'
            . ' data-nota1="' . $data_nota1 . '"'
            . ' data-nota2="' . $data_nota2 . '"'
            . ' data-nota3="' . $data_nota3 . '"'
            . ' data-inas1="' . $data_inas1 . '"'
            . ' data-inas2="' . $data_inas2 . '"'
            . ' data-inas3="' . $data_inas3 . '">'
            . 'Editar</button>';
        echo '</td>';

        echo '<td>' . $fila['cedula'] . '</td>';
        echo '<td>' . $fila['nombre_estudiante'] . '</td>';
        echo '<td>' . $fila['apellido'] . '</td>';
        echo '<td>' . $mostrarAnio . '</td>';
        echo '<td>' . $mostrarSeccion . '</td>';
        echo '<td class="assignature-student">' . htmlspecialchars($nombreAsignaturaMostrar, ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . (isset($fila['nota_lapso1']) && $fila['nota_lapso1'] !== null ? $fila['nota_lapso1'] : '—') . '</td>';
        echo '<td>' . (isset($fila['nota_lapso2']) && $fila['nota_lapso2'] !== null ? $fila['nota_lapso2'] : '—') . '</td>';
        echo '<td>' . (isset($fila['nota_lapso3']) && $fila['nota_lapso3'] !== null ? $fila['nota_lapso3'] : '—') . '</td>';
        echo '<td>' . (isset($fila['inasistencia_lapso1']) && $fila['inasistencia_lapso1'] !== null ? $fila['inasistencia_lapso1'] : '—') . '</td>';
        echo '<td>' . (isset($fila['inasistencia_lapso2']) && $fila['inasistencia_lapso2'] !== null ? $fila['inasistencia_lapso2'] : '—') . '</td>';
        echo '<td>' . (isset($fila['inasistencia_lapso3']) && $fila['inasistencia_lapso3'] !== null ? $fila['inasistencia_lapso3'] : '—') . '</td>';
        echo '</tr>';
    }

} catch (PDOException $error) {
    echo '<tr><td colspan="15" style="color:red;">Error en la consulta: ' . $error->getMessage() . '</td></tr>';
}
?>



