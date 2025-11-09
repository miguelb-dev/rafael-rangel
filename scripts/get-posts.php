<?php

include '../users/config/data-base.php';

try {
    // Consulta para obtener todas las publicaciones y de ser posible, la primera imagen de la publicacion
    $query = "SELECT publicacion.id_publicacion AS id_post, titulo_publicacion, descripcion_publicacion, fecha_publicacion, tipo AS tipo_archivo_adjunto, nombre_archivo
    FROM publicacion
    LEFT JOIN archivo_adjunto 
    ON publicacion.id_publicacion = archivo_adjunto.id_publicacion
    AND tipo = 'imagen' /* Evita duplicar la misma publicacion pero intentando mostrar un documento como si fuera una imagen */
    AND orden = 1       /* Evita duplicar la misma publicacion pero con una imagen diferente */
    ORDER BY fecha_publicacion DESC;";

    $statement = $conexion->prepare($query);
    $statement->execute();
    
    $publicaciones = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($publicaciones);
    
} catch (PDOException $error) {
    // En caso de error, devolver array vacío
    echo json_encode([]);
}
?>