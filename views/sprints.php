<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $inicio = $_POST['fecha_inicio'];
    $fin = $_POST['fecha_fin'];

    $sql = "INSERT INTO sprints (nombre, fecha_inicio, fecha_fin) VALUES ('$nombre', '$inicio', '$fin')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Sprint creado correctamente ✅</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

$result = $conn->query("SELECT * FROM sprints");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sprints</title>
</head>
<body>
    <h2>Gestionar Sprints</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre"><br><br>
        <label>Fecha inicio:</label>
        <input type="date" name="fecha_inicio"><br><br>
        <label>Fecha fin:</label>
        <input type="date" name="fecha_fin"><br><br>
        <button type="submit">Guardar Sprint</button>
    </form>

    <h3>Lista de Sprints</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li><?php echo $row['nombre'] . " (" . $row['fecha_inicio'] . " a " . $row['fecha_fin'] . ")"; ?></li>
        <?php } ?>
    </ul>

    <p><a href="../index/index.php">⬅ Volver al inicio</a></p>
</body>
</html>
