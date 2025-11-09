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

// Validación básica de sesión
if (!$id_docente && !$id_admin) {
    http_response_code(401);
    echo json_encode(array('error' => 'Sesión no válida'));
    exit;
}

// Captura de datos del formulario
$titulo      = isset($_POST['titulo_evento']) ? trim($_POST['titulo_evento']) : '';
$descripcion = isset($_POST['descripcion_evento']) ? trim($_POST['descripcion_evento']) : '';
$fecha       = isset($_POST['fecha_evento']) ? $_POST['fecha_evento'] : '';
$laborable   = isset($_POST['laborable']) ? $_POST['laborable'] : 'No';

// Validación de campos obligatorios
if ($titulo === '' || $fecha === '') {
    http_response_code(400);
    echo json_encode(array('error' => 'Faltan campos obligatorios'));
    exit;
}

// Inserta el evento en la base de datos
$sql = "
INSERT INTO calendario_escolar (
    titulo_evento,
    descripcion_evento,
    fecha_evento,
    laborable,
    id_docente,
    id_administrador
) VALUES (
    :titulo,
    :descripcion,
    :fecha,
    :laborable,
    :id_docente,
    :id_admin
)
";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':laborable', $laborable);
    $stmt->bindParam(':id_docente', $id_docente);
    $stmt->bindParam(':id_admin', $id_admin);
    $stmt->execute();

    echo json_encode(array('success' => 'Evento creado correctamente'));

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('error' => 'Error al guardar el evento: ' . $e->getMessage()));
}
?>
