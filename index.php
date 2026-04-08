<?php
$host   = 'localhost';
$dbname = 'registro_retro_db';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}

$sprints = $pdo->query("
    SELECT s.*,
        SUM(CASE WHEN r.categoria = 'logro'       THEN 1 ELSE 0 END) AS total_logros,
        SUM(CASE WHEN r.categoria = 'impedimento' THEN 1 ELSE 0 END) AS total_impedimentos,
        SUM(CASE WHEN r.categoria = 'accion'      THEN 1 ELSE 0 END) AS total_acciones,
        SUM(CASE WHEN r.categoria = 'accion' AND r.cumplida = 1 THEN 1 ELSE 0 END) AS acciones_cumplidas
    FROM sprints s
    LEFT JOIN retro_items r ON r.sprint_id = s.id
    GROUP BY s.id
    ORDER BY s.fecha_inicio DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Retrospectivas</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; color: #333; }
        header {
            background: #1a73e8; color: white;
            padding: 18px 30px;
            display: flex; align-items: center; justify-content: space-between;
        }
        header h1 { font-size: 1.4rem; }
        nav a {
            color: white; text-decoration: none; margin-left: 12px;
            padding: 6px 14px; border-radius: 4px;
            background: rgba(255,255,255,0.15);
        }
        nav a:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 980px; margin: 30px auto; padding: 0 20px; }
        .hero {
            background: white; border-radius: 10px;
            padding: 26px 30px; margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .hero h2 { color: #1a73e8; margin-bottom: 8px; }
        .hero p { color: #666; font-size: 0.95rem; line-height: 1.6; }
        .btn {
            display: inline-block; margin-top: 14px;
            padding: 10px 22px; background: #1a73e8;
            color: white; border-radius: 5px;
            text-decoration: none; font-size: 0.93rem;
        }
        .btn:hover { background: #1558b0; }
        .section-title {
            font-size: 1rem; font-weight: bold;
            color: #444; margin-bottom: 14px;
        }
        .cards { display: grid; gap: 16px; }
        .card {
            background: white; border-radius: 8px;
            padding: 20px 24px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
            border-left: 5px solid #1a73e8;
        }
        .card h3 { font-size: 1rem; color: #1a73e8; margin-bottom: 4px; }
        .card .fechas { font-size: 0.82rem; color: #999; margin-bottom: 12px; }
        .stats { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 14px; }
        .stat {
            padding: 4px 12px; border-radius: 12px;
            font-size: 0.8rem; font-weight: bold;
        }
        .stat-logro       { background: #d4edda; color: #155724; }
        .stat-impedimento { background: #f8d7da; color: #721c24; }
        .stat-accion      { background: #fff3cd; color: #856404; }
        .stat-cumplida    { background: #cce5ff; color: #004085; }
        .card-actions a {
            font-size: 0.85rem; margin-right: 12px;
            text-decoration: none; color: #1a73e8;
        }
        .card-actions a.del { color: #dc3545; }
        .empty {
            text-align: center; padding: 40px;
            color: #999; background: white; border-radius: 8px;
        }
    </style>
</head>
<body>

<header>
    <h1>Registro de Retrospectivas Agiles</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="menu.php">Menu</a>
        <a href="menu.php?accion=nuevo_sprint">Nuevo Sprint</a>
    </nav>
</header>

<div class="container">

    <div class="hero">
        <h2>Panel principal</h2>
        <p>
            Gestiona las retrospectivas de cada sprint. Registra logros, impedimentos,
            acciones de mejora y da seguimiento a los compromisos asumidos por el equipo.
        </p>
        <a href="menu.php?accion=nuevo_sprint" class="btn">Crear nuevo sprint</a>
    </div>

    <p class="section-title">Sprints registrados (<?= count($sprints) ?>)</p>

    <?php if (empty($sprints)): ?>
        <div class="empty">
            <p>No hay sprints registrados aun.</p>
            <a href="menu.php?accion=nuevo_sprint" class="btn" style="margin-top:12px;">Crear el primero</a>
        </div>
    <?php else: ?>
        <div class="cards">
            <?php foreach ($sprints as $s): ?>
            <div class="card">
                <h3><?= htmlspecialchars($s['nombre']) ?></h3>
                <div class="fechas">
                    Inicio: <?= htmlspecialchars($s['fecha_inicio']) ?> &nbsp;|&nbsp;
                    Fin: <?= htmlspecialchars($s['fecha_fin']) ?>
                </div>
                <div class="stats">
                    <span class="stat stat-logro">Logros: <?= $s['total_logros'] ?></span>
                    <span class="stat stat-impedimento">Impedimentos: <?= $s['total_impedimentos'] ?></span>
                    <span class="stat stat-accion">Acciones: <?= $s['total_acciones'] ?></span>
                    <span class="stat stat-cumplida">Cumplidas: <?= $s['acciones_cumplidas'] ?></span>
                </div>
                <div class="card-actions">
                    <a href="menu.php?accion=ver_sprint&id=<?= $s['id'] ?>">Ver detalle</a>
                    <a href="menu.php?accion=nuevo_item&sprint_id=<?= $s['id'] ?>">Agregar item</a>
                    <a href="menu.php?accion=editar_sprint&id=<?= $s['id'] ?>">Editar sprint</a>
                    <a href="menu.php?accion=eliminar_sprint&id=<?= $s['id'] ?>"
                       class="del"
                       onclick="return confirm('Eliminar este sprint y todos sus items?')">Eliminar</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>