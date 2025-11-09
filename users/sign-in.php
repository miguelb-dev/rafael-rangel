<?php
session_start();
require 'config/data-base.php';

if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Buscar en tabla estudiante
    $consultaEstudiante = $conexion->prepare("SELECT id_estudiante AS id, contrasena FROM estudiante WHERE email = ?");
    $consultaEstudiante->execute([$correo]);
    $estudiante = $consultaEstudiante->fetch(PDO::FETCH_ASSOC);

    // Buscar en tabla docente
    $consultaDocente = $conexion->prepare("SELECT id_docente AS id, contrasena FROM docente WHERE email = ?");
    $consultaDocente->execute([$correo]);
    $docente = $consultaDocente->fetch(PDO::FETCH_ASSOC);

    // Buscar en tabla administrador
    $consultaAdmin = $conexion->prepare("SELECT id_administrador AS id, contrasena FROM administrador WHERE email = ?");
    $consultaAdmin->execute([$correo]);
    $admin = $consultaAdmin->fetch(PDO::FETCH_ASSOC);

    // Si no se encontró en ninguna tabla
    if (!$estudiante && !$docente && !$admin) {
        $_SESSION['mensaje'] = "Este correo no está registrado.";
        header('Location: ../public/views/sign-in.php');
        exit;
    }

    // Determinar el usuario y el rol
    if ($estudiante) {
        $usuario = $estudiante;
        $rol = 'estudiante';
    } elseif ($docente) {
        $usuario = $docente;
        $rol = 'profesor';
    } else {
        $usuario = $admin;
        $rol = 'administrador';
    }

    // Verificar contraseña
    if (password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['rol'] = $rol;

        // === NUEVO: guardar el ID específico según el rol ===
        if ($rol === 'profesor') {
            $_SESSION['id_docente'] = $usuario['id'];
        } elseif ($rol === 'estudiante') {
            $_SESSION['id_estudiante'] = $usuario['id'];
        } elseif ($rol === 'administrador') {
            $_SESSION['id_administrador'] = $usuario['id'];
        }

        // Redirigir según el rol
        if ($rol === 'estudiante') {
            header('Location: ../users/student/inicio-estudiante.php');
        } elseif ($rol === 'profesor') {
            header('Location: ../users/professor/inicio-docente.php');
        } else {
            header('Location: ../users/admin/inicio-admin.php');
        }
        exit;
    } else {
        $_SESSION['mensaje'] = "La contraseña es incorrecta.";
        header('Location: ../public/views/sign-in.php');
        exit;
    }

} else {
    $_SESSION['mensaje'] = "Debes completar todos los campos.";
    header('Location: ../public/views/sign-in.php');
    exit;
}
