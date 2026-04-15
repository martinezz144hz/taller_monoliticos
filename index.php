<?php
// index.php
require_once __DIR__ . '/../config/db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Retrospectivas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Registro de Retrospectivas Scrum</h1>

    <ul>
        <li><a href="../views/nueva_retro.php">Crear nueva retrospectiva</a></li>
        <li><a href="../views/listar_retros.php">Ver retrospectivas anteriores</a></li>
        <li><a href="../views/sprints.php">Gestionar sprints</a></li>
    </ul>
</body>