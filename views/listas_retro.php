<?php
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Retrospectivas anteriores</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Encabezado azul -->
    <header>
        <h1>Retrospectivas anteriores</h1>
    </header>

    <!-- Contenido gris -->
    <main>
        <h2>Lista de retrospectivas</h2>
        <table>
            <tr>
                <th>Título</th>
                <th>Fecha</th>
                <th>Descripción</th>
            </tr>
            <!-- Aquí irán los registros de la base -->
            <tr>
                <td>Ejemplo 1</td>
                <td>2026-05-08</td>
                <td>Descripción de prueba</td>
            </tr>
        </table>

        <!-- Botón volver -->
        <a href="../index/index.php" class="btn">← Volver al inicio</a>
    </main>
</body>
</html>