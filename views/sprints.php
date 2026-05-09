<!-- sprints.php -->
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
        <form>
            <label for="nombre">Nombre del Sprint:</label>
            <input type="text" id="nombre" name="nombre">

            <label for="fecha_inicio">Fecha inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio">

            <label for="fecha_fin">Fecha fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin">

            <button type="submit" class="btn">Guardar Sprint</button>
        </form>

        <!-- Lista -->
        <h2>Lista de Sprints</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
            </tr>
            <!-- Aquí irán los registros -->
        </table>

        <!-- Volver -->
        <a href="../index/index.php" class="btn">← Volver al inicio</a>
    </main>
</body>
</html>