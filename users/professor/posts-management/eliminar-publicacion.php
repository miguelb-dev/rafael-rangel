<?php
// eliminar-publicacion.php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../../config/data-base.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['success' => false, 'error' => 'ID inválido']);
    exit;
}

$id = intval($_POST['id']);

try {
    // Traer adjuntos para eliminar archivos físicos
    $stmt = $conexion->prepare("SELECT tipo, nombre_archivo FROM archivo_adjunto WHERE id_publicacion = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $adjuntos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($adjuntos as $a) {
        if ($a['tipo'] === 'imagen') {
            $ruta = "../../../public/uploads/img/" . $a['nombre_archivo'];
            if (file_exists($ruta)) @unlink($ruta);
        } else {
            $ruta = "../../../public/uploads/doc/" . $a['nombre_archivo'];
            if (file_exists($ruta)) @unlink($ruta);
        }
    }

    // Eliminar registros
    $stmt = $conexion->prepare("DELETE FROM archivo_adjunto WHERE id_publicacion = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $stmt = $conexion->prepare("DELETE FROM publicacion WHERE id_publicacion = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al eliminar publicación', 'detail' => $e->getMessage()]);
}
?>
