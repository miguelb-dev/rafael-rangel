<?php
// obtener-estudiante.php
date_default_timezone_set('America/Caracas');
require '../../config/data-base.php';

// Captura de filtros desde GET
$materia = isset($_GET['materia']) ? trim($_GET['materia']) : '';
$id_anio_seccion = isset($_GET['anio_seccion']) && $_GET['anio_seccion'] !== '' ? intval($_GET['anio_seccion']) : 0;

// Captura del docente y rol desde la sesión
$id_docente = isset($_SESSION['id_docente']) ? intval($_SESSION['id_docente']) : 0;
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

// Validación: si no hay docente identificado, mostrar mensaje
if ($id_docente === 0) {
    echo "<tr><td colspan='15' style='color:red;'>Error: docente no identificado.</td></tr>";
    exit;
}

// Construcción dinámica del WHERE
$where = [];

if ($materia !== '') {
    $where[] = "a.nombre = " . $conexion->quote($materia);
}

if ($id_anio_seccion > 0) {
    $where[] = "an.id_anio_seccion = " . intval($id_anio_seccion);
}

// La cláusula EXISTS debe aceptar coincidir incluso cuando id_anio_seccion puede ser NULL.
// Comparamos id_asignatura siempre y para id_anio_seccion permitimos equivalencia NULL.
$where[] = "EXISTS (
    SELECT 1 FROM docente_asignatura_anio_seccion daas
    WHERE daas.id_docente = " . intval($id_docente) . "
        AND daas.id_asignatura = eaas.id_asignatura
        AND ( (daas.id_anio_seccion IS NULL AND eaas.id_anio_seccion IS NULL) OR daas.id_anio_seccion = eaas.id_anio_seccion )
)";

$condicion = count($where) ? "WHERE " . implode(" AND ", $where) : "";

// Consulta principal (trae id_periodo_escolar AS id_periodo)
$sql = "
SELECT 
    eaas.id_estudiante,
    e.cedula,
    e.nombre AS nombre_estudiante,
    e.apellido,
    an.anio,
    an.seccion,
    a.nombre AS nombre_asignatura,
    eaas.id_asignatura,
    eaas.id_anio_seccion,
    eaas.id_estudiante_asignatura,
    pe.id_periodo_escolar AS id_periodo,
    pe.nota_lapso1,
    pe.nota_lapso2,
    pe.nota_lapso3,
    pe.inasistencia_lapso1,
    pe.inasistencia_lapso2,
    pe.inasistencia_lapso3
FROM estudiante e
JOIN estudiante_asignatura_anio_seccion eaas ON e.id_estudiante = eaas.id_estudiante
JOIN anio_seccion an ON eaas.id_anio_seccion = an.id_anio_seccion
JOIN asignatura a ON eaas.id_asignatura = a.id_asignatura
LEFT JOIN periodo_escolar pe ON pe.id_estudiante_asignatura = eaas.id_estudiante_asignatura
$condicion
ORDER BY an.anio, an.seccion, a.nombre, e.cedula
";

try {
    $consulta = $conexion->query($sql);
    $hayResultados = false;

    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $hayResultados = true;

        // Determinar value del checkbox según rol: profesor -> id_periodo ; admin/otros -> id_estudiante
        if ($rol === 'profesor') {
            $checkboxValue = (isset($fila['id_periodo']) && intval($fila['id_periodo']) > 0) ? intval($fila['id_periodo']) : '';
        } else {
            $checkboxValue = isset($fila['id_estudiante']) ? intval($fila['id_estudiante']) : '';
        }

        echo "<tr>
            <td class='seleccion-edicion' style='display: none;'>
                <input type='radio' name='estudiante_editar'>
            </td>

            <td class='seleccion-col' style='display: none;'>";
        if ($checkboxValue !== '') {
            echo "<input type='checkbox' name='seleccion[]' value='" . htmlspecialchars($checkboxValue, ENT_QUOTES, 'UTF-8') . "'>";
        } else {
            echo "<input type='checkbox' disabled>";
        }
        echo "</td>

            <td style='display:none;'>
                <button type='button' class='edit-btn'
                    data-id_estudiante='" . htmlspecialchars($fila['id_estudiante'], ENT_QUOTES, 'UTF-8') . "'
                    data-cedula='" . htmlspecialchars($fila['cedula'], ENT_QUOTES, 'UTF-8') . "'
                    data-nombre='" . htmlspecialchars($fila['nombre_estudiante'], ENT_QUOTES, 'UTF-8') . "'
                    data-apellido='" . htmlspecialchars($fila['apellido'], ENT_QUOTES, 'UTF-8') . "'
                    data-asignatura='" . htmlspecialchars($fila['nombre_asignatura'], ENT_QUOTES, 'UTF-8') . "'
                    data-id_asignatura='" . htmlspecialchars($fila['id_asignatura'], ENT_QUOTES, 'UTF-8') . "'
                    data-id_anio_seccion='" . htmlspecialchars($fila['id_anio_seccion'], ENT_QUOTES, 'UTF-8') . "'
                    data-id_estudiante_asignatura='" . htmlspecialchars($fila['id_estudiante_asignatura'], ENT_QUOTES, 'UTF-8') . "'
                    data-id_periodo='" . htmlspecialchars($fila['id_periodo'], ENT_QUOTES, 'UTF-8') . "'
                    data-nota1='" . htmlspecialchars($fila['nota_lapso1'], ENT_QUOTES, 'UTF-8') . "'
                    data-nota2='" . htmlspecialchars($fila['nota_lapso2'], ENT_QUOTES, 'UTF-8') . "'
                    data-nota3='" . htmlspecialchars($fila['nota_lapso3'], ENT_QUOTES, 'UTF-8') . "'
                    data-inas1='" . htmlspecialchars($fila['inasistencia_lapso1'], ENT_QUOTES, 'UTF-8') . "'
                    data-inas2='" . htmlspecialchars($fila['inasistencia_lapso2'], ENT_QUOTES, 'UTF-8') . "'
                    data-inas3='" . htmlspecialchars($fila['inasistencia_lapso3'], ENT_QUOTES, 'UTF-8') . "'>
                    Editar
                </button>
            </td>

            <td>" . htmlspecialchars($fila['cedula'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($fila['nombre_estudiante'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($fila['apellido'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($fila['anio'], ENT_QUOTES, 'UTF-8') . "° Año</td>
            <td>" . htmlspecialchars($fila['seccion'], ENT_QUOTES, 'UTF-8') . "</td>
            <td class='assignature-student'>" . htmlspecialchars($fila['nombre_asignatura'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . (isset($fila['nota_lapso1']) ? htmlspecialchars($fila['nota_lapso1'], ENT_QUOTES, 'UTF-8') : '—') . "</td>
            <td>" . (isset($fila['nota_lapso2']) ? htmlspecialchars($fila['nota_lapso2'], ENT_QUOTES, 'UTF-8') : '—') . "</td>
            <td>" . (isset($fila['nota_lapso3']) ? htmlspecialchars($fila['nota_lapso3'], ENT_QUOTES, 'UTF-8') : '—') . "</td>
            <td>" . (isset($fila['inasistencia_lapso1']) ? htmlspecialchars($fila['inasistencia_lapso1'], ENT_QUOTES, 'UTF-8') : '—') . "</td>
            <td>" . (isset($fila['inasistencia_lapso2']) ? htmlspecialchars($fila['inasistencia_lapso2'], ENT_QUOTES, 'UTF-8') : '—') . "</td>
            <td>" . (isset($fila['inasistencia_lapso3']) ? htmlspecialchars($fila['inasistencia_lapso3'], ENT_QUOTES, 'UTF-8') : '—') . "</td>
        </tr>";
    }

    if (!$hayResultados) {
        echo "<tr><td colspan='15' style='color:gray;'>No hay estudiantes asignados a este docente.</td></tr>";
    }
} catch (PDOException $error) {
    echo "<tr><td colspan='15' style='color:red;'>Error en la consulta: " . htmlspecialchars($error->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
}
?>

