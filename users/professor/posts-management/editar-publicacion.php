<?php
// editar-publicacion.php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../../config/data-base.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['success' => false, 'error' => 'ID inválido']);
    exit;
}

$id = intval($_POST['id']);
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';

try {
    $stmt = $conexion->prepare("UPDATE publicacion SET titulo_publicacion = :titulo, descripcion_publicacion = :descripcion WHERE id_publicacion = :id");
    $stmt->bindParam(':titulo', $title);
    $stmt->bindParam(':descripcion', $description);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Eliminar adjuntos marcados
    if (isset($_POST['imagenes_eliminar']) && is_array($_POST['imagenes_eliminar'])) {
        foreach ($_POST['imagenes_eliminar'] as $nombre) {
            $ruta = "../../../public/uploads/img/" . $nombre;
            if (file_exists($ruta)) @unlink($ruta);
            $stmt = $conexion->prepare("DELETE FROM archivo_adjunto WHERE id_publicacion = :id AND nombre_archivo = :nombre AND tipo = 'imagen'");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
        }
    }

    if (isset($_POST['documentos_eliminar']) && is_array($_POST['documentos_eliminar'])) {
        foreach ($_POST['documentos_eliminar'] as $nombre) {
            $ruta = "../../../public/uploads/doc/" . $nombre;
            if (file_exists($ruta)) @unlink($ruta);
            $stmt = $conexion->prepare("DELETE FROM archivo_adjunto WHERE id_publicacion = :id AND nombre_archivo = :nombre AND tipo = 'documento'");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
        }
    }

    // Subir nuevas imágenes
    if (isset($_FILES['images'])) {
        $total = count($_FILES['images']['name']);
        for ($i = 0; $i < $total; $i++) {
            $nombre = basename($_FILES['images']['name'][$i]);
            $tmp = $_FILES['images']['tmp_name'][$i];
            if ($tmp === '' || !is_uploaded_file($tmp)) continue;

            $destino = "../../../public/uploads/img/" . $nombre;
            if (move_uploaded_file($tmp, $destino)) {
                $orden = 0;
                $stmt = $conexion->prepare("INSERT INTO archivo_adjunto (id_publicacion, tipo, nombre_archivo, orden) VALUES (:id, 'imagen', :nombre, :orden)");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':orden', $orden);
                $stmt->execute();
            }
        }
    }

    // Subir nuevos documentos
    if (isset($_FILES['documents'])) {
        $total = count($_FILES['documents']['name']);
        for ($i = 0; $i < $total; $i++) {
            $nombre = basename($_FILES['documents']['name'][$i]);
            $tmp = $_FILES['documents']['tmp_name'][$i];
            if ($tmp === '' || !is_uploaded_file($tmp)) continue;

            $destino = "../../../public/uploads/doc/" . $nombre;
            if (move_uploaded_file($tmp, $destino)) {
                $stmt = $conexion->prepare("INSERT INTO archivo_adjunto (id_publicacion, tipo, nombre_archivo, orden) VALUES (:id, 'documento', :nombre, 0)");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
            }
        }
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al actualizar publicación', 'detail' => $e->getMessage()]);
}
?>
