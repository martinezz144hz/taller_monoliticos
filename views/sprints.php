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
        <?php foreach ($result as $key => $value) {?>
            <li><?php echo $value['nombre'] . " (" . $value['fecha_inicio'] . " a " . $value['fecha_fin'] . ")"; ?></li>
        <?php } ?>
    </ul>

    <p><a href="../index.php">⬅ Volver al inicio</a></p>
</body>
</html>
