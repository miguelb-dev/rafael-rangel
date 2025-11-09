<?php
// Establece la zona horaria para evitar warnings
date_default_timezone_set('America/Caracas');

// Conexión a la base de datos
include('../../config/data-base.php');

// Aumenta el límite de caracteres para GROUP_CONCAT (por si hay muchas asignaciones)
$conexion->query("SET SESSION group_concat_max_len = 100000");

// Verifica si se recibió una materia por GET y si no está vacía
$materiaFiltrada = '';
if (isset($_GET['materia']) && $_GET['materia'] !== '') {
    $materiaFiltrada = trim($_GET['materia']);
}

// Construye la consulta principal para obtener docentes y sus datos
// NUEVO: usar LEFT JOIN para incluir docentes sin asignaciones
$sql = "
SELECT DISTINCT
    d.id_docente,
    d.cedula, d.nombre, d.apellido, d.fecha_nacimiento, d.genero,
    d.direccion, d.telefono_personal, d.email
FROM docente d
LEFT JOIN docente_asignatura_anio_seccion daas ON d.id_docente = daas.id_docente
LEFT JOIN asignatura a ON daas.id_asignatura = a.id_asignatura
";

// Aplica filtro por materia si se especificó
if ($materiaFiltrada !== '') {
    // NUEVO: mantener el filtro por materia; al usar LEFT JOIN, esto sólo mantendrá docentes que tengan esa asignatura
    $sql .= "WHERE a.nombre = " . $conexion->quote($materiaFiltrada);
}


try {
    $consulta = $conexion->query($sql);

    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
        // Obtener asignaciones reales del docente con nombres
        $sqlAsignaciones = "
            SELECT a.nombre AS asignatura, s.anio, s.seccion
            FROM docente_asignatura_anio_seccion daas
            JOIN asignatura a ON daas.id_asignatura = a.id_asignatura
            JOIN anio_seccion s ON daas.id_anio_seccion = s.id_anio_seccion
            WHERE daas.id_docente = ?
        ";
        if ($materiaFiltrada !== '') {
            $sqlAsignaciones .= " AND a.nombre = " . $conexion->quote($materiaFiltrada);
        }
        $sqlAsignaciones .= " ORDER BY a.nombre, s.anio, s.seccion";

        $stmtAsignaciones = $conexion->prepare($sqlAsignaciones);
        $stmtAsignaciones->execute([$fila['id_docente']]);
        $rows = $stmtAsignaciones->fetchAll(PDO::FETCH_ASSOC);

        // Construye una línea por cada asignación: "Física 1°A"
        $asignacionesTexto = '';
        $asignaciones_final = [];

        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                $nombre = $row['asignatura'];
                $seccion = $row['anio'] . '°' . $row['seccion'];
                $asignacionesTexto .= "<span class='badge'>" . htmlspecialchars("{$nombre} {$seccion}") . "</span>";

                // Obtener IDs para el botón de edición
                // ID de asignatura
                $stmtId = $conexion->prepare("SELECT id_asignatura FROM asignatura WHERE nombre = ?");
                $stmtId->execute([$nombre]);
                $id_asignatura = $stmtId->fetchColumn();

                // ID de año/sección
                $stmtSec = $conexion->prepare("SELECT id_anio_seccion FROM anio_seccion WHERE anio = ? AND seccion = ?");
                $stmtSec->execute([$row['anio'], $row['seccion']]);
                $id_anio_seccion = $stmtSec->fetchColumn();

                if ($id_asignatura && $id_anio_seccion) {
                    $asignaciones_final[$id_asignatura][] = $id_anio_seccion;
                }
            }
        } else {
            // NUEVO: si no hay asignaciones, mostrar texto indicativo en preview (opcional)
            $asignacionesTexto = "<span class='badge badge-empty'>Sin asignaciones</span>";
        }

        // Codifica asignaciones para el botón de edición
        $asignaciones_json = [];
        foreach ($asignaciones_final as $id_asignatura => $id_anios) {
            $asignaciones_json[] = [
                'id_asignatura' => $id_asignatura,
                'id_anio_seccion' => $id_anios
            ];
        }

        $data_asignaciones = htmlspecialchars(json_encode($asignaciones_json), ENT_QUOTES, 'UTF-8');

        // Renderiza la fila del docente
        echo "<tr>
            <td class='seleccion-edicion' style='display: none;'>
                <input type='radio' name='docente_editar'>
            </td>

            <td class='seleccion-col' style='display: none;'>
                <input type='checkbox' name='seleccion[]' value='{$fila['id_docente']}'>
            </td>

            <td style='display:none;'>
                <button type='button' class='edit-btn'
                    data-id='{$fila['id_docente']}'
                    data-cedula='{$fila['cedula']}'
                    data-nombre='{$fila['nombre']}'
                    data-apellido='{$fila['apellido']}'
                    data-email='{$fila['email']}'
                    data-telefono='{$fila['telefono_personal']}'
                    data-direccion='{$fila['direccion']}'
                    data-genero='{$fila['genero']}'
                    data-fecha='{$fila['fecha_nacimiento']}'
                    data-asignaciones='{$data_asignaciones}'>
                    Editar
                </button>
            </td>

            <td>{$fila['cedula']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['apellido']}</td>
            <td class='email'>{$fila['email']}</td>
            <td class='telephone'>{$fila['telefono_personal']}</td>
            <td>{$fila['direccion']}</td>
            <td>{$fila['genero']}</td>
            <td>{$fila['fecha_nacimiento']}</td>

            <td colspan='2'>
                <div class='asignaciones-preview unificada'>
                    {$asignacionesTexto}
                </div>
            </td>
        </tr>";
    }

} catch (PDOException $error) {
    echo "<tr><td colspan='13' style='color:red;'>Error en la consulta: {$error->getMessage()}</td></tr>";
}
?>
