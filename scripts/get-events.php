<?php

include '../users/config/data-base.php';

try {
    // Consulta para obtener los eventos del calendario
    $query = "SELECT id_calendario, titulo_evento, descripcion_evento, laborable, fecha_evento
                FROM calendario_escolar
                ORDER BY fecha_evento;";

    $statement = $conexion->prepare($query);
    $statement->execute();
    
    $eventos = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($eventos);
    
} catch (PDOException $error) {
    // En caso de error, devolver array vacío
    echo json_encode([]);
}
?>