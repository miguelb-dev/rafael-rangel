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
    // Consulta del evento
    $queryPost = "SELECT id_publicacion AS id_post, titulo_publicacion, descripcion_publicacion, fecha_publicacion
                    FROM publicacion
                    WHERE id_publicacion = :id";
    $stmtPost = $conexion->prepare($queryPost);
    $stmtPost->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtPost->execute();
    $publicacion = $stmtPost->fetch(PDO::FETCH_ASSOC);

    // Consulta de imágenes
    $queryImages = "SELECT id_archivo_adjunto, id_publicacion, tipo, nombre_archivo, orden
                    FROM archivo_adjunto
                    WHERE id_publicacion = :id AND tipo = 'imagen'
                    ORDER BY orden";
    $stmtImages = $conexion->prepare($queryImages);
    $stmtImages->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtImages->execute();
    $imagenes = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

    // Consulta de documentos
    $queryDocs = "SELECT id_archivo_adjunto, id_publicacion, tipo, nombre_archivo, orden
                    FROM archivo_adjunto
                    WHERE id_publicacion = :id AND tipo = 'documento'
                    ORDER BY orden";
    $stmtDocs = $conexion->prepare($queryDocs);
    $stmtDocs->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtDocs->execute();
    $documentos = $stmtDocs->fetchAll(PDO::FETCH_ASSOC);

    // Estructura combinada
    $resultado = [
        'publicacion' => $publicacion,
        'imagenes' => $imagenes,
        'documentos' => $documentos
    ];

    header('Content-Type: application/json');
    echo json_encode($resultado);

} catch (PDOException $error) {
    echo json_encode(['error' => 'Error en la base de datos']);
}