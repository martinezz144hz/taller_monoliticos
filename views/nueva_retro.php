<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sprint_id = $_POST['sprint_id'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO retro_items (sprint_id, categoria, descripcion) VALUES ('$sprint_id', '$categoria', '$descripcion')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Retro registrada correctamente ✅</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Retrospectiva</title>
</head>
<body>
    <h2>Crear nueva retrospectiva</h2>
    <form method="POST">
        <label>Sprint:</label>
        <select name="sprint_id">
            <?php
            $result = $conn->query("SELECT id, nombre FROM sprints");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
            }
            ?>
        </select><br><br>

        <label>Categoría:</label>
        <select name="categoria">
            <option value="accion">Acción</option>
            <option value="logro">Logro</option>
            <option value="impedimento">Impedimento</option>
            <option value="comentario">Comentario</option>
            <option value="otro">Otro</option>
        </select><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" rows="4" cols="40"></textarea><br><br>

        <button type="submit">Guardar</button>
    </form>

    <p><a href="../index/index.php">⬅ Volver al inicio</a></p>
</body>
</html>
