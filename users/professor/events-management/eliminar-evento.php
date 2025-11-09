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

// Captura del ID del evento a eliminar
$id_calendario = isset($_POST['id_calendario']) ? $_POST['id_calendario'] : null;

// Validación del ID
if (!$id_calendario) {
    http_response_code(400);
    echo json_encode(array('error' => 'ID de evento no recibido'));
    exit;
}

// Elimina el evento de la base de datos
$sql = "DELETE FROM calendario_escolar WHERE id_calendario = :id_calendario";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_calendario', $id_calendario);
    $stmt->execute();

    echo json_encode(array('success' => 'Evento eliminado correctamente'));

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('error' => 'Error al eliminar el evento: ' . $e->getMessage()));
}
?>
