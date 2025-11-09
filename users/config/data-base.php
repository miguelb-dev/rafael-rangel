<?php

// Credenciales de la base de datos
$server = 'localhost'; 
$usuario = 'root'; 
$contraseña = ''; 
$database = 'rafael_rangel';

try {
    // Establece la conexión con PDO
    $conexion = new PDO("mysql:host=$server;dbname=$database;", $usuario, $contraseña);

    // Configura PDO para lanzar excepciones en caso de error
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $error) {
    // Si ocurre un error, muestra el mensaje y detiene la ejecución
    die('Error de conexión: ' . $error->getMessage());
}

?>