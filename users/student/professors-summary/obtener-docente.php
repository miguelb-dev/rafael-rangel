<?php
date_default_timezone_set('America/Caracas');

if (session_status() === PHP_SESSION_NONE) { session_start(); }

include('../../config/data-base.php');

// Verifica que el estudiante esté identificado
if (!isset($_SESSION['id_estudiante'])) {
    echo "<tr><td colspan='4' style='color:red;'>Error: estudiante no identificado.</td></tr>";
    exit;
}
$id_estudiante = intval($_SESSION['id_estudiante']);

try {
    // Consulta única: traer eaas -> daas -> docente en tiempo real
    $sql = "
    SELECT
      eaas.id_asignatura,
      eaas.id_anio_seccion AS eaas_id_anio_seccion,
      a.nombre AS nombre_asignatura,
      s.anio AS anio,
      s.seccion AS seccion,
      daas.id_docente AS daas_id_docente,
      daas.id_asignatura AS daas_id_asignatura,
      daas.id_anio_seccion AS daas_id_anio_seccion,
      d.nombre AS nombre_docente,
      d.apellido AS apellido_docente,
      d.email,
      d.telefono_personal
    FROM estudiante_asignatura_anio_seccion eaas
    JOIN asignatura a ON eaas.id_asignatura = a.id_asignatura
    LEFT JOIN anio_seccion s ON eaas.id_anio_seccion = s.id_anio_seccion
    LEFT JOIN docente_asignatura_anio_seccion daas
      ON daas.id_asignatura = eaas.id_asignatura
      AND (
           (daas.id_anio_seccion IS NULL AND eaas.id_anio_seccion IS NULL)
        OR (daas.id_anio_seccion = eaas.id_anio_seccion)
      )
    LEFT JOIN docente d ON daas.id_docente = d.id_docente
    WHERE eaas.id_estudiante = ?
    ORDER BY a.nombre, s.anio, s.seccion, d.apellido, d.nombre
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->execute(array($id_estudiante));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // DEBUG: registra filas devueltas por PHP (descomenta para usar)
    // error_log('obtener-docente: rows fetched = ' . count($rows));
    // error_log('obtener-docente: ' . json_encode($rows));

    if (!$rows) {
        echo "<tr><td colspan='4' style='color:gray;'>No hay asignaciones registradas para este estudiante.</td></tr>";
        exit;
    }

    // Agrupar por asignatura+anio+seccion para mostrar "Sin docente" cuando corresponda
    $grouped = array();
    foreach ($rows as $r) {
        // clave por id_asignatura + eaas_id_anio_seccion (compatibilidad con PHP sin ??)
        $eaas_sec = isset($r['eaas_id_anio_seccion']) ? $r['eaas_id_anio_seccion'] : '';
        $key = $r['id_asignatura'] . '|' . $eaas_sec;
        if (!isset($grouped[$key])) $grouped[$key] = array('meta' => $r, 'docentes' => array());

        // Si hay un docente asociado (daas_id_docente no null) lo guardamos
        if (!empty($r['daas_id_docente'])) {
            $grouped[$key]['docentes'][] = $r;
        }
    }

    foreach ($grouped as $g) {
        $meta = $g['meta'];
        $nomAsign = htmlspecialchars($meta['nombre_asignatura'], ENT_QUOTES, 'UTF-8');
        $anio = (isset($meta['anio']) && $meta['anio'] !== null && $meta['anio'] !== '') ? htmlspecialchars($meta['anio'], ENT_QUOTES, 'UTF-8') : '—';
        $seccion = (isset($meta['seccion']) && $meta['seccion'] !== null && $meta['seccion'] !== '') ? htmlspecialchars($meta['seccion'], ENT_QUOTES, 'UTF-8') : '—';
        $displayAsign = $nomAsign . " <small class='muted'>(" . $anio . "° " . $seccion . ")</small>";

        if (count($g['docentes']) === 0) {
            echo "<tr>
                <td>{$displayAsign}</td>
                <td>Sin docente asignado</td>
                <td class='email'>—</td>
                <td class='telephone'>—</td>
            </tr>";
            continue;
        }

        foreach ($g['docentes'] as $d) {
            $nombre_docente = htmlspecialchars(trim($d['nombre_docente'] . ' ' . $d['apellido_docente']), ENT_QUOTES, 'UTF-8');
            $correo = htmlspecialchars($d['email'], ENT_QUOTES, 'UTF-8');
            $telefono = htmlspecialchars($d['telefono_personal'], ENT_QUOTES, 'UTF-8');

            echo "<tr>
                <td>{$displayAsign}</td>
                <td>Prof. {$nombre_docente}</td>
                <td class='email'>{$correo}</td>
                <td class='telephone'>{$telefono}</td>
            </tr>";
        }
    }

} catch (PDOException $e) {
    error_log('obtener-docente PDOException: ' . $e->getMessage());
    echo "<tr><td colspan='4' style='color:red;'>Error al obtener datos.</td></tr>";
    exit;
}
?>


