<?php

include '../users/config/data-base.php';

// Recibir el ID desde el cuerpo JSON
$input = json_decode(file_get_contents("php://input"), true);
$id = isset($input['id']) ? intval($input['id']) : 0;

if ($id <= 0) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

try {
    $query = "SELECT id_calendario, titulo_evento, descripcion_evento, laborable, fecha_evento
                FROM calendario_escolar
                WHERE id_calendario = :id
                ORDER BY fecha_evento";

    $statement = $conexion->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $eventos = $statement->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($eventos);

} catch (PDOException $error) {
    echo json_encode([]);
}

?>