<?php
require_once __DIR__ . '/../config/db.php';
$result = $conn->query("SELECT r.id, r.categoria, r.descripcion, s.nombre AS sprint 
                        FROM retro_items r 
                        JOIN sprints s ON r.sprint_id = s.id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Retrospectivas</title>
</head>
<body>
    <h2>Retrospectivas anteriores</h2>
    <table border="1">
        <tr>
            <th>Sprint</th>
            <th>Categoría</th>
            <th>Descripción</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['sprint']; ?></td>
                <td><?php echo $row['categoria']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <p><a href="../index/index.php">⬅ Volver al inicio</a></p>
</body>
</html>
