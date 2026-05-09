<?php
require_once dirname(dirname(__FILE__)) . '\controllers\retroItemController.php';
$controllerRetroIntem = new retroItemController();
$result = $controllerRetroIntem->showAllSprint();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $controllerRetroIntem->CreateRetroItemSprit($_POST);    
    echo '<p>'.$response.'</p>';   
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
            foreach ($result as $key => $value) {
                echo "<option value='{$value['id']}'>{$value['nombre']}</option>";                
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

    <p><a href="../index.php">⬅ Volver al inicio</a></p>
</body>
</html>
