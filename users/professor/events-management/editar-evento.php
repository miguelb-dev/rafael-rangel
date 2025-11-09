<?php
// editar-evento.php
date_default_timezone_set('America/Caracas');
session_start();

// Forzar salida JSON
header('Content-Type: application/json; charset=utf-8');

// Conexión a la base de datos
include('../../config/data-base.php');

// Captura del usuario actual (docente o administrador)
$id_docente = isset($_SESSION['id_docente']) ? $_SESSION['id_docente'] : null;
$id_admin = isset($_SESSION['id_administrador']) ? $_SESSION['id_administrador'] : null;

// Validación básica de sesión
if (!$id_docente && !$id_admin) {
    http_response_code(401);
    echo json_encode(array('success' => false, 'error' => 'Sesión no válida'));
    exit;
}

// Captura de datos del formulario
$id_calendario = isset($_POST['id_calendario']) ? $_POST['id_calendario'] : null;
$titulo        = isset($_POST['titulo_evento']) ? trim($_POST['titulo_evento']) : null; // NUEVO: título editable (opcional)
$fecha         = isset($_POST['fecha_evento']) ? $_POST['fecha_evento'] : '';
$descripcion   = isset($_POST['descripcion_evento']) ? trim($_POST['descripcion_evento']) : '';
$laborable     = isset($_POST['laborable']) ? $_POST['laborable'] : 'No';

// Validación de campos obligatorios
if (!$id_calendario || $fecha === '') {
    http_response_code(400);
    echo json_encode(array('success' => false, 'error' => 'Faltan campos obligatorios'));
    exit;
}

// Construir SET dinámico manteniendo tu lógica original
$setParts = array();
$params = array();

$setParts[] = "fecha_evento = :fecha";
$params[':fecha'] = $fecha;

$setParts[] = "descripcion_evento = :descripcion";
$params[':descripcion'] = $descripcion;

$setParts[] = "laborable = :laborable";
$params[':laborable'] = $laborable;

// NUEVO: incluir título si fue enviado y no está vacío
if ($titulo !== null && $titulo !== '') {
    $setParts[] = "titulo_evento = :titulo";
    $params[':titulo'] = $titulo;
}

$params[':id_calendario'] = $id_calendario;

$sql = "UPDATE calendario_escolar SET " . implode(", ", $setParts) . " WHERE id_calendario = :id_calendario";

try {
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(array('success' => false, 'error' => 'Error en la preparación de la consulta'));
        exit;
    }

    // Vincular parámetros
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    if ($stmt->execute()) {
        echo json_encode(array('success' => true, 'message' => 'Evento actualizado correctamente'));
    } else {
        $err = $stmt->errorInfo();
        http_response_code(500);
        echo json_encode(array('success' => false, 'error' => 'Error al actualizar el evento: ' . (isset($err[2]) ? $err[2] : 'Sin detalle')));
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('success' => false, 'error' => 'Error al actualizar el evento: ' . $e->getMessage()));
}
?>
