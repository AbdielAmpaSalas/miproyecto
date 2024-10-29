<?php
require_once __DIR__ . '/includes/functions.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validación básica de los datos
        $proyecto = sanitizeInput($_POST['proyecto']);
        $descripcion = sanitizeInput($_POST['descripcion']);
        $color = sanitizeInput($_POST['color']);
        $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
        $fechaEntrega = $_POST['fechaEntrega'];

        if (!$precio) {
            throw new Exception("El precio debe ser un número válido.");
        }

        crearProyecto($proyecto, $descripcion, $color, $precio, $fechaEntrega);
        header("Location: index.php?mensaje=Proyecto creado con éxito");
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
    <title>Agregar Nueva Proyecto</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Proyecto</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>Proyecto: <input type="text" name="proyecto" required></label>
            <label>Descripción: <input type="text" name="descripcion" required></label><br>
            <label>Color: <input type="color" name="color" required></label><br>
            <label>Precio S/.: <input type="text" name="precio" required></label><br>
            <label>Fecha de Entrega: <input type="date" name="fechaEntrega" required></label>
            <input type="submit" value="Crear Proyecto" class="button">
        </form>
        <a href="index.php" class="button">Volver a la lista de Proyectos</a>
    </div>
</body>
</html>
