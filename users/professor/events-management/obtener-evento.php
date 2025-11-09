<?php
// Establece la zona horaria
date_default_timezone_set('America/Caracas');

// Inicia sesión para identificar al usuario
session_start();

// Conexión a la base de datos
include('../../config/data-base.php');

// Captura del usuario actual (docente o administrador)
$id_docente = isset($_SESSION['id_docente']) ? $_SESSION['id_docente'] : null;
$id_admin = isset($_SESSION['id_administrador']) ? $_SESSION['id_administrador'] : null;


$where = ''; // Elimina el filtro por usuario


// Consulta los eventos disponibles
$sql = "
SELECT 
    id_calendario,
    titulo_evento,
    descripcion_evento,
    laborable,
    fecha_evento
FROM calendario_escolar
$where
ORDER BY fecha_evento DESC
";

try {
    $consulta = $conexion->query($sql);
    $eventos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    // Devuelve los eventos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($eventos);

} catch (PDOException $error) {
    http_response_code(500);
    echo json_encode(array('error' => 'Error en la consulta: ' . $error->getMessage()));
}
?>
