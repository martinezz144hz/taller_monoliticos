
<?php
require_once dirname(dirname(__FILE__)) . '/controllers/sprintsController.php';

$controllerSprint = new SprintsController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $controllerSprint->createSprint($_POST);
    echo '<p>'.$response.'</p>';
}

// Obtener lista de sprints
$result = $controllerSprint->showAllSprints();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Sprints</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    
    <header>
        <h1>Gestionar Sprints</h1>
    </header>

    
    <main>
        <form method="POST">
            <label for="nombre">Nombre del Sprint:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="fecha_inicio">Fecha inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <button type="submit" class="btn">Guardar Sprint</button>
        </form>

        
        <h3>Lista de Sprints</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
            </tr>
            <?php
            if ($result && count($result) > 0) {
                foreach ($result as $row) {
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

      
        <a href="../index.php" class="btn">← Volver al inicio</a>
    </main>
</body>
</html>