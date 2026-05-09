<!-- sprints.php -->
<?php
// Conexión a la base de datos
include '../config/db.php';

// Consulta a la tabla sprints
$sql = "SELECT * FROM sprints";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Sprints</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Encabezado azul -->
    <header>
        <h1>Gestionar Sprints</h1>
    </header>

    <!-- Contenido gris -->
    <main>
        <!-- Formulario -->
        <form method="POST" action="../models/sprint.php">
            <label for="nombre">Nombre del Sprint:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="fecha_inicio">Fecha inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <button type="submit" class="btn">Guardar Sprint</button>
        </form>

        <!-- Lista -->
        <h3>Lista de Sprints</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
            </tr>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nombre']}</td>
                            <td>{$row['fecha_inicio']}</td>
                            <td>{$row['fecha_fin']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay sprints registrados</td></tr>";
            }
            ?>
        </table>

        <!-- Volver -->
        <a href="../index/index.php" class="btn">← Volver al inicio</a>
    </main>
</body>
</html>