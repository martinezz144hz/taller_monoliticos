index.php
php<?php
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

menu.php
php<?php
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

$accion    = $_GET['accion']    ?? 'menu';
$id        = isset($_GET['id'])        ? (int)$_GET['id']        : 0;
$sprint_id = isset($_GET['sprint_id']) ? (int)$_GET['sprint_id'] : 0;
$msg       = '';
$msg_tipo  = 'ok';

// ── GUARDAR SPRINT ────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_sprint'])) {
    $nombre       = trim($_POST['nombre']       ?? '');
    $fecha_inicio = trim($_POST['fecha_inicio'] ?? '');
    $fecha_fin    = trim($_POST['fecha_fin']    ?? '');

    if ($nombre && $fecha_inicio && $fecha_fin) {
        if (!empty($_POST['id'])) {
            $pdo->prepare("UPDATE sprints SET nombre=?, fecha_inicio=?, fecha_fin=? WHERE id=?")
                ->execute([$nombre, $fecha_inicio, $fecha_fin, (int)$_POST['id']]);
            $msg = "Sprint actualizado correctamente.";
        } else {
            $pdo->prepare("INSERT INTO sprints (nombre, fecha_inicio, fecha_fin) VALUES (?, ?, ?)")
                ->execute([$nombre, $fecha_inicio, $fecha_fin]);
            $msg = "Sprint creado correctamente.";
        }
        $accion = 'menu';
    } else {
        $msg      = "Todos los campos del sprint son obligatorios.";
        $msg_tipo = 'warn';
    }
}

// ── GUARDAR ITEM ──────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_item'])) {
    $item_sprint_id = (int)($_POST['sprint_id']     ?? 0);
    $categoria      = trim($_POST['categoria']       ?? '');
    $descripcion    = trim($_POST['descripcion']     ?? '');
    $cumplida       = $_POST['cumplida'] === '' ? null : (int)$_POST['cumplida'];
    $fecha_revision = trim($_POST['fecha_revision']  ?? '') ?: null;

    if ($item_sprint_id && $categoria && $descripcion) {
        if (!empty($_POST['id'])) {
            $pdo->prepare("UPDATE retro_items
                           SET sprint_id=?, categoria=?, descripcion=?, cumplida=?, fecha_revision=?
                           WHERE id=?")
                ->execute([$item_sprint_id, $categoria, $descripcion,
                           $cumplida, $fecha_revision, (int)$_POST['id']]);
            $msg = "Item actualizado correctamente.";
        } else {
            $pdo->prepare("INSERT INTO retro_items
                           (sprint_id, categoria, descripcion, cumplida, fecha_revision)
                           VALUES (?, ?, ?, ?, ?)")
                ->execute([$item_sprint_id, $categoria, $descripcion,
                           $cumplida, $fecha_revision]);
            $msg = "Item registrado correctamente.";
        }
        header("Location: menu.php?accion=ver_sprint&id=$item_sprint_id&msg=" . urlencode($msg));
        exit;
    } else {
        $msg      = "Sprint, categoria y descripcion son obligatorios.";
        $msg_tipo = 'warn';
    }
}

// ── ELIMINAR SPRINT ───────────────────────────────────────────────────────────
if ($accion === 'eliminar_sprint' && $id > 0) {
    $pdo->prepare("DELETE FROM sprints WHERE id=?")->execute([$id]);
    header("Location: index.php");
    exit;
}

// ── ELIMINAR ITEM ─────────────────────────────────────────────────────────────
if ($accion === 'eliminar_item' && $id > 0) {
    $stmt = $pdo->prepare("SELECT sprint_id FROM retro_items WHERE id=?");
    $stmt->execute([$id]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo->prepare("DELETE FROM retro_items WHERE id=?")->execute([$id]);
    $back = $fila ? $fila['sprint_id'] : 0;
    header("Location: menu.php?accion=ver_sprint&id=$back");
    exit;
}

// ── CARGAR DATOS PARA EDICION ─────────────────────────────────────────────────
$sprint        = null;
$item          = null;
$sprints_lista = [];

if ($accion === 'editar_sprint' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM sprints WHERE id=?");
    $stmt->execute([$id]);
    $sprint = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$sprint) { header("Location: index.php"); exit; }
}

if ($accion === 'ver_sprint' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM sprints WHERE id=?");
    $stmt->execute([$id]);
    $sprint = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$sprint) { header("Location: index.php"); exit; }
    if (isset($_GET['msg'])) $msg = htmlspecialchars($_GET['msg']);
}

if ($accion === 'nuevo_item' || $accion === 'editar_item') {
    $sprints_lista = $pdo->query("SELECT id, nombre FROM sprints ORDER BY fecha_inicio DESC")
                         ->fetchAll(PDO::FETCH_ASSOC);
    if ($accion === 'editar_item' && $id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM retro_items WHERE id=?");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$item) { header("Location: index.php"); exit; }
    }
}

$categorias = [
    'logro'       => 'Logro',
    'impedimento' => 'Impedimento',
    'accion'      => 'Accion',
    'comentario'  => 'Comentario',
    'otro'        => 'Otro',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menu - Retrospectivas</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; color: #333; }
        header {
            background: #1a73e8; color: white;
            padding: 18px 30px;
            display: flex; align-items: center; justify-content: space-between;
        }
        header h1 { font-size: 1.3rem; }
        nav a {
            color: white; text-decoration: none; margin-left: 12px;
            padding: 6px 14px; border-radius: 4px;
            background: rgba(255,255,255,0.15);
        }
        nav a:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 800px; margin: 30px auto; padding: 0 20px; }
        .card {
            background: white; border-radius: 10px;
            padding: 28px 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        h2 { color: #1a73e8; margin-bottom: 20px; font-size: 1.2rem; }
        h3 { font-size: 1rem; color: #444; margin: 20px 0 10px; }
        .msg {
            padding: 10px 16px; border-radius: 5px;
            margin-bottom: 18px; font-size: 0.93rem;
            background: #d4edda; color: #155724; border: 1px solid #c3e6cb;
        }
        .msg.warn { background: #fff3cd; color: #856404; border-color: #ffeeba; }
        label {
            display: block; font-size: 0.88rem;
            color: #555; margin-bottom: 4px;
            margin-top: 14px; font-weight: bold;
        }
        input[type=text], input[type=date], textarea, select {
            width: 100%; padding: 9px 12px;
            border: 1px solid #ccc; border-radius: 5px;
            font-size: 0.93rem; font-family: Arial, sans-serif;
        }
        textarea { resize: vertical; min-height: 80px; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #1a73e8; }
        .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .btn {
            margin-top: 22px; padding: 10px 26px;
            background: #1a73e8; color: white;
            border: none; border-radius: 5px;
            font-size: 0.95rem; cursor: pointer;
        }
        .btn:hover { background: #1558b0; }
        .btn-sec {
            margin-top: 22px; margin-left: 10px;
            padding: 10px 20px; background: #6c757d;
            color: white; border: none; border-radius: 5px;
            font-size: 0.95rem; cursor: pointer;
            text-decoration: none; display: inline-block;
        }
        .btn-sec:hover { background: #545b62; }
        .menu-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 10px; }
        .menu-item {
            background: white; border-radius: 8px;
            padding: 22px 20px; text-align: center;
            text-decoration: none; color: #333;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
            transition: transform 0.15s, box-shadow 0.15s;
            border-top: 4px solid #1a73e8;
        }
        .menu-item:hover { transform: translateY(-3px); box-shadow: 0 6px 14px rgba(0,0,0,0.1); }
        .menu-item span { display: block; font-size: 0.95rem; font-weight: bold; }
        .menu-item small { color: #888; font-size: 0.82rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.88rem; }
        thead tr { background: #e8f0fe; }
        th { padding: 9px 12px; text-align: left; color: #1a73e8; font-size: 0.83rem; }
        td { padding: 9px 12px; border-bottom: 1px solid #eee; vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        .badge {
            display: inline-block; padding: 2px 9px;
            border-radius: 10px; font-size: 0.77rem; font-weight: bold;
        }
        .badge-logro       { background: #d4edda; color: #155724; }
        .badge-impedimento { background: #f8d7da; color: #721c24; }
        .badge-accion      { background: #fff3cd; color: #856404; }
        .badge-comentario  { background: #e2e3e5; color: #383d41; }
        .badge-otro        { background: #d1ecf1; color: #0c5460; }
        .cumplida-si  { color: #155724; font-weight: bold; }
        .cumplida-no  { color: #721c24; font-weight: bold; }
        .cumplida-nd  { color: #999; }
        .tbl-actions a { font-size: 0.82rem; margin-right: 8px; text-decoration: none; color: #1a73e8; }
        .tbl-actions a.del { color: #dc3545; }
        .info-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px; }
        .info-box { background: #f8f9fa; border-radius: 6px; padding: 12px 16px; }
        .info-box small { font-size: 0.8rem; color: #888; }
        .info-box p { font-size: 0.93rem; margin-top: 2px; }
        .empty-items { text-align: center; padding: 30px; color: #999; font-size: 0.9rem; }
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

<?php if ($msg): ?>
    <div class="msg <?= $msg_tipo === 'warn' ? 'warn' : '' ?>"><?= $msg ?></div>
<?php endif; ?>

<!-- ═══ MENU PRINCIPAL ════════════════════════════════════════════════════════ -->
<?php if ($accion === 'menu'): ?>
<div class="card">
    <h2>Que deseas hacer?</h2>
    <div class="menu-grid">
        <a href="menu.php?accion=nuevo_sprint" class="menu-item">
            <span>Nuevo Sprint</span>
            <small>Registrar un sprint nuevo</small>
        </a>
        <a href="index.php" class="menu-item">
            <span>Ver todos los sprints</span>
            <small>Historial completo</small>
        </a>
    </div>
</div>

<!-- ═══ FORMULARIO SPRINT ════════════════════════════════════════════════════ -->
<?php elseif ($accion === 'nuevo_sprint' || $accion === 'editar_sprint'): ?>
<div class="card">
    <h2><?= $accion === 'editar_sprint' ? 'Editar Sprint' : 'Nuevo Sprint' ?></h2>
    <form method="POST" action="menu.php">
        <input type="hidden" name="form_sprint" value="1">
        <?php if ($sprint): ?>
            <input type="hidden" name="id" value="<?= $sprint['id'] ?>">
        <?php endif; ?>

        <label>Nombre del sprint *</label>
        <input type="text" name="nombre" placeholder="Ej: Sprint 4 - Modulo de pagos"
               value="<?= htmlspecialchars($sprint['nombre'] ?? '') ?>" required>

        <div class="row2">
            <div>
                <label>Fecha de inicio *</label>
                <input type="date" name="fecha_inicio"
                       value="<?= htmlspecialchars($sprint['fecha_inicio'] ?? '') ?>" required>
            </div>
            <div>
                <label>Fecha de fin *</label>
                <input type="date" name="fecha_fin"
                       value="<?= htmlspecialchars($sprint['fecha_fin'] ?? '') ?>" required>
            </div>
        </div>

        <button type="submit" class="btn">
            <?= $accion === 'editar_sprint' ? 'Guardar cambios' : 'Crear sprint' ?>
        </button>
        <a href="index.php" class="btn-sec">Cancelar</a>
    </form>
</div>

<!-- ═══ VER DETALLE DEL SPRINT ═══════════════════════════════════════════════ -->
<?php elseif ($accion === 'ver_sprint' && $sprint): ?>

<?php
$items_stmt = $pdo->prepare("SELECT * FROM retro_items WHERE sprint_id=? ORDER BY categoria, created_at");
$items_stmt->execute([$sprint['id']]);
$todos_items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <h2>Detalle del sprint</h2>

    <div class="info-row">
        <div class="info-box">
            <small>Nombre</small>
            <p><?= htmlspecialchars($sprint['nombre']) ?></p>
        </div>
        <div class="info-box">
            <small>Periodo</small>
            <p><?= htmlspecialchars($sprint['fecha_inicio']) ?> al <?= htmlspecialchars($sprint['fecha_fin']) ?></p>
        </div>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
        <h3 style="margin:0;">Items de la retrospectiva</h3>
        <a href="menu.php?accion=nuevo_item&sprint_id=<?= $sprint['id'] ?>"
           class="btn" style="margin-top:0; padding:7px 16px; font-size:0.85rem;">
            Agregar item
        </a>
    </div>

    <?php if (empty($todos_items)): ?>
        <div class="empty-items">No hay items registrados para este sprint.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Descripcion</th>
                    <th>Cumplida</th>
                    <th>Fecha revision</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($todos_items as $it): ?>
                <tr>
                    <td>
                        <span class="badge badge-<?= $it['categoria'] ?>">
                            <?= ucfirst($it['categoria']) ?>
                        </span>
                    </td>
                    <td><?= nl2br(htmlspecialchars($it['descripcion'])) ?></td>
                    <td>
                        <?php if ($it['categoria'] === 'accion'): ?>
                            <?php if ($it['cumplida'] === null): ?>
                                <span class="cumplida-nd">Pendiente</span>
                            <?php elseif ($it['cumplida']): ?>
                                <span class="cumplida-si">Si</span>
                            <?php else: ?>
                                <span class="cumplida-no">No</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="cumplida-nd">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $it['fecha_revision'] ? htmlspecialchars($it['fecha_revision']) : '-' ?></td>
                    <td class="tbl-actions">
                        <a href="menu.php?accion=editar_item&id=<?= $it['id'] ?>">Editar</a>
                        <a href="menu.php?accion=eliminar_item&id=<?= $it['id'] ?>"
                           class="del"
                           onclick="return confirm('Eliminar este item?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="btn-sec" style="margin-top:20px; margin-left:0;">Volver al inicio</a>
</div>

<!-- ═══ FORMULARIO ITEM ══════════════════════════════════════════════════════ -->
<?php elseif ($accion === 'nuevo_item' || $accion === 'editar_item'): ?>
<div class="card">
    <h2><?= $accion === 'editar_item' ? 'Editar Item' : 'Agregar Item a la Retrospectiva' ?></h2>
    <form method="POST" action="menu.php">
        <input type="hidden" name="form_item" value="1">
        <?php if ($item): ?>
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
        <?php endif; ?>

        <label>Sprint *</label>
        <select name="sprint_id" required>
            <option value="">Seleccione un sprint</option>
            <?php
            $sel_sprint = $item['sprint_id'] ?? $sprint_id;
            foreach ($sprints_lista as $sl):
            ?>
                <option value="<?= $sl['id'] ?>" <?= $sl['id'] == $sel_sprint ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sl['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Categoria *</label>
        <select name="categoria" required>
            <option value="">Seleccione una categoria</option>
            <?php foreach ($categorias as $val => $label): ?>
                <option value="<?= $val ?>" <?= ($item['categoria'] ?? '') === $val ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Descripcion *</label>
        <textarea name="descripcion"
                  placeholder="Describe el logro, impedimento, accion, etc."><?= htmlspecialchars($item['descripcion'] ?? '') ?></textarea>

        <div class="row2">
            <div>
                <label>Cumplida (solo para acciones)</label>
                <select name="cumplida">
                    <option value="">Pendiente / N/A</option>
                    <option value="1" <?= isset($item['cumplida']) && $item['cumplida'] == 1 ? 'selected' : '' ?>>Si</option>
                    <option value="0" <?= isset($item['cumplida']) && $item['cumplida'] === '0' ? 'selected' : '' ?>>No</option>
                </select>
            </div>
            <div>
                <label>Fecha de revision</label>
                <input type="date" name="fecha_revision"
                       value="<?= htmlspecialchars($item['fecha_revision'] ?? '') ?>">
            </div>
        </div>

        <button type="submit" class="btn">
            <?= $accion === 'editar_item' ? 'Guardar cambios' : 'Guardar item' ?>
        </button>
        <?php
        $back_id  = $item['sprint_id'] ?? $sprint_id;
        $back_url = $back_id ? "menu.php?accion=ver_sprint&id=$back_id" : "index.php";
        ?>
        <a href="<?= $back_url ?>" class="btn-sec">Cancelar</a>
    </form>
</div>

<?php endif; ?>

</div>
</body>
</html>