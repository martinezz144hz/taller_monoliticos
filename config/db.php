<?php
// config/db.php
$host = "localhost";   // servidor
$user = "root";        // usuario de MySQL
$pass = "";            // contraseña (déjala vacía si no tienes)
$dbname = "registro_retro_db"; // nombre de la base de datos

$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>