<?php
// agregar-publicacion.php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../../config/data-base.php';

try {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if ($title === '') {
        echo json_encode(['success' => false, 'error' => 'Título requerido']);
        exit;
    }

    $stmt = $conexion->prepare("INSERT INTO publicacion (titulo_publicacion, descripcion_publicacion) VALUES (:titulo, :descripcion)");
    $stmt->bindParam(':titulo', $title);
    $stmt->bindParam(':descripcion', $description);
    $stmt->execute();
    $newId = $conexion->lastInsertId();

    // Imágenes subidas
    if (isset($_FILES['images'])) {
        $total = count($_FILES['images']['name']);
        for ($i = 0; $i < $total; $i++) {
            $nombre = basename($_FILES['images']['name'][$i]);
            $tmp = $_FILES['images']['tmp_name'][$i];
            if ($tmp === '' || !is_uploaded_file($tmp)) continue;

            $destino = "../../../public/uploads/img/" . $nombre;
            if (move_uploaded_file($tmp, $destino)) {
                $orden = ($i == 0) ? 1 : 0;
                $stmt = $conexion->prepare("INSERT INTO archivo_adjunto (id_publicacion, tipo, nombre_archivo, orden) VALUES (:id, 'imagen', :nombre, :orden)");
                $stmt->bindParam(':id', $newId);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':orden', $orden);
                $stmt->execute();
            }
        }
    }

    // Documentos subidos
    if (isset($_FILES['documents'])) {
        $total = count($_FILES['documents']['name']);
        for ($i = 0; $i < $total; $i++) {
            $nombre = basename($_FILES['documents']['name'][$i]);
            $tmp = $_FILES['documents']['tmp_name'][$i];
            if ($tmp === '' || !is_uploaded_file($tmp)) continue;

            $destino = "../../../public/uploads/doc/" . $nombre;
            if (move_uploaded_file($tmp, $destino)) {
                $stmt = $conexion->prepare("INSERT INTO archivo_adjunto (id_publicacion, tipo, nombre_archivo, orden) VALUES (:id, 'documento', :nombre, 0)");
                $stmt->bindParam(':id', $newId);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
            }
        }
    }

    echo json_encode(['success' => true, 'id' => $newId]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al crear publicación', 'detail' => $e->getMessage()]);
}
?>
