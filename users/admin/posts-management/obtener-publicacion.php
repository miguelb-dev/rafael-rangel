<?php
// obtener-publicacion.php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../../config/data-base.php';

try {
    $stmt = $conexion->prepare("SELECT id_publicacion, titulo_publicacion, descripcion_publicacion FROM publicacion ORDER BY id_publicacion DESC");
    $stmt->execute();
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$publicaciones) {
        echo json_encode([]);
        exit;
    }

    $stmtAdj = $conexion->prepare("SELECT tipo, nombre_archivo, orden FROM archivo_adjunto WHERE id_publicacion = :id ORDER BY orden DESC, nombre_archivo ASC");

    $resultado = [];
    foreach ($publicaciones as $pub) {
        $id = $pub['id_publicacion'];

        $stmtAdj->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtAdj->execute();
        $adjuntos = $stmtAdj->fetchAll(PDO::FETCH_ASSOC);

        $imagenes = [];
        $documentos = [];
        foreach ($adjuntos as $a) {
            if ($a['tipo'] === 'imagen') {
                $imagenes[] = ['nombre_archivo' => $a['nombre_archivo'], 'orden' => $a['orden']];
            } else {
                $documentos[] = ['nombre_archivo' => $a['nombre_archivo']];
            }
        }

        $resultado[] = [
            'id_publicacion' => $id,
            'titulo_publicacion' => $pub['titulo_publicacion'],
            'descripcion_publicacion' => $pub['descripcion_publicacion'],
            'imagenes' => $imagenes,
            'documentos' => $documentos
        ];
    }

    echo json_encode($resultado);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en servidor al obtener publicaciones', 'detail' => $e->getMessage()]);
}
?>
