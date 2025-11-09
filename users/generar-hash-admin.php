<?php
// Cambia esta contraseña por la que quieras asignar al administrador
$claveOriginal = 'admin123';

// Genera el hash seguro
$hash = password_hash($claveOriginal, PASSWORD_DEFAULT);

// Muestra el resultado
echo "Contraseña original: " . $claveOriginal . "<br>";
echo "Hash generado: <br><textarea rows='3' cols='80'>" . $hash . "</textarea>";
?>
