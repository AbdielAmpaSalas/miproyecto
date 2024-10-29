<?php
require_once __DIR__ . '/includes/functions.php';
$error = '';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$proyecto = obtenerProyectoPorId($_GET['id']);

if (!$proyecto) {
    header("Location: index.php?mensaje=Proyecto no encontrado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validación de datos y sanitización
        $nombre = sanitizeInput($_POST['proyecto']);
        $descripcion = sanitizeInput($_POST['descripcion']);
        $color = sanitizeInput($_POST['color']);
        $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
        $fechaEntrega = $_POST['fechaEntrega'];
        $entregado = isset($_POST['entregado']);

        if (!$precio) {
            throw new Exception("El precio debe ser un número válido.");
        }

        actualizarProyecto($_GET['id'], $nombre, $descripcion, $color, $precio, $fechaEntrega, $entregado);
        header("Location: index.php?mensaje=Proyecto actualizado con éxito");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Proyecto</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>Proyecto: <input type="text" name="proyecto" value="<?php echo htmlspecialchars($proyecto['proyecto']); ?>" required></label>
            <label>Descripción: <input type="text" name="descripcion" value="<?php echo htmlspecialchars($proyecto['descripcion']); ?>" required></label><br>
            <label>Color: <input type="color" name="color" value="<?php echo htmlspecialchars($proyecto['color']); ?>" required></label><br>
            <label>Precio S/.: <input type="text" name="precio" value="<?php echo htmlspecialchars($proyecto['precio']); ?>" required></label><br>
            <label>Fecha de Entrega: <input type="date" name="fechaEntrega" value="<?php echo htmlspecialchars(formatDate($proyecto['fechaEntrega'])); ?>" required></label><br>
            <label>Entregado: <input type="checkbox" name="entregado" <?php echo $proyecto['entregado'] ? 'checked' : ''; ?>></label>
            <input type="submit" value="Actualizar Proyecto" class="button">
        </form>
        <a href="index.php" class="button">Volver a la lista de Proyectos</a>
    </div>
</body>
</html>
