<?php

require_once dirname(dirname(__FILE__)) . '\controllers\retroItemController.php';


$retroItemController = new retroItemController();
$result = $retroItemController->showAllRetroItem();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Retrospectivas anteriores</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Retrospectivas anteriores</h2>
    <table border="1">
        <tr>
            <th>Sprint</th>
            <th>Categoría</th>
            <th>Descripción</th>
        </tr>
        <?php foreach ($result as $key => $value) {?>
        
            <tr>
                <td><?php echo $value['sprint']; ?></td>
                <td><?php echo $value['categoria']; ?></td>
                <td><?php echo $value['descripcion']; ?></td>
            </tr>
        </table>

        <!-- Botón volver -->
        <a href="../index/index.php" class="btn">← Volver al inicio</a>
    </main>
</body>
</html>