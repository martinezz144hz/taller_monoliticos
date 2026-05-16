<?php
require_once __DIR__ . '/../models/dataBase.php';
require_once __DIR__ . '/../models/retroItem.php';

$retroModel = new RetroItem();
$retros = $retroModel->getWithSprint();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Retrospectivas</title>
    
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
   
    <header>
        <h1>Registro de Retrospectivas Scrum</h1>
    </header>

    
    <main>
        <h2>Retrospectivas anteriores</h2>

        <table>
            <thead>
                <tr>
                    <th>Sprint</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Cumplida</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($retros)): ?>
                    <?php foreach ($retros as $retro): ?>
                        <tr>
                            <td><?= htmlspecialchars($retro['sprint']) ?></td>
                            <td><?= htmlspecialchars($retro['categoria']) ?></td>
                            <td><?= htmlspecialchars($retro['descripcion']) ?></td>
                            <td><?= !empty($retro['cumplida']) && $retro['cumplida'] == 1 ? '✅' : '❌' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay retrospectivas registradas aún.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

      
        <a href="../index.php" class="btn">⬅ Volver al inicio</a>
    </main>
</body>
</html>