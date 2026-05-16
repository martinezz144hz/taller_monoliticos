<!-- sprints.php -->
<?php
require_once dirname(dirname(__FILE__)) . '\controllers\sprintsController.php';
require_once dirname(dirname(__FILE__)) . '\controllers\retroItemController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controllerRetroIntem = new retroItemController();
    $result = $controllerRetroIntem->showAllSprint();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = $controllerRetroIntem->CreateRetroItemSprit($_POST);    
        echo '<p>'.$response.'</p>';   
    }
}
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

    <h3>Lista de Sprints</h3>
    <ul>
        <?php foreach ($result as $key => $value) {?>
            <li><?php echo $value['nombre'] . " (" . $value['fecha_inicio'] . " a " . $value['fecha_fin'] . ")"; ?></li>
        <?php } ?>
    </ul>

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