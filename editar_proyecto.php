<?php
require_once __DIR__ . '/includes/functions.php';
$error = '';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$proyecto = obtenerProyectoPorId($_GET['id']);

if (!$proyecto) {
    header("Location: index.php?mensaje=Proyecto no encontrada");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $count = actualizarProyecto($_GET['id'], $_POST['proyecto'], $_POST['descripcion'], $_POST['precio'], $_POST['fechaEntrega'], isset($_POST['entregado']));
        if ($count > 0) {
            header("Location: index.php?mensaje=Proyecto actualizada con éxito");
            exit;
        } else {
            $error = "No se pudo actualizar el Proyecto.";
        }
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
            <label>Descripción: <input type="text" name="descripcion" value="<?php echo htmlspecialchars($proyecto['descripcion']); ?>" required></label>
            <label>Color: <input type="color" name="color" value="" <?php echo htmlspecialchars($proyecto['color']);?> required></label>
            <label>Precio S/.: <input type="text" name="precio" value="<?php echo htmlspecialchars($proyecto['precio']); ?>" required></label>
            <label>Fecha de Entrega: <input type="date" name="fechaEntrega" value="<?php echo formatDate($proyecto['fechaEntrega']); ?>" required></label>
            <label>Entregado: <input type="checkbox" name="entregado" <?php echo $proyecto['entregado'] ? 'checked' : ''; ?>></label>
            <input type="submit" value="Actualizar Proyecto">
        </form>
        <a href="index.php" class="button">Volver a la lista de Proyectos</a>
    </div>
</body>
</html>
