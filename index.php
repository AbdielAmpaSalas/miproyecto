<?php
require_once __DIR__ . '/includes/functions.php';
$mensaje = '';

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $count = eliminarProyecto($_GET['id']);
    $mensaje = $count > 0 ? "Proyecto eliminado con éxito." : "No se pudo eliminar el Proyecto.";
}

$proyectos = obtenerProyecto();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Entrega de Proyectos en Melamina</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Gestión de Entrega de Proyectos en Melamina</h1>

    <?php if ($mensaje): ?>
        <div class="<?php echo $count > 0 ? 'success' : 'error'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
    <h2>Lista de Proyectos</h2>
    <table>
        <tr>
            <th>Proyecto</th>
            <th>Descripción</th>
            <th>Color</th>
            <th>Fecha de Entrega</th>
            <th>Precio S/.</th>
            <th>Entregado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($proyectos as $proyecto): ?>
        <tr>
            <td><?php echo htmlspecialchars($proyecto['proyecto']); ?></td>
            <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
            <td>
                <div style="width: 30px; height: 30px; background-color: <?php echo htmlspecialchars($proyecto['color']); ?>; display: inline-block;"></div>
            </td>
            <td><?php echo formatDate($proyecto['fechaEntrega']); ?></td>
            <td><?php echo htmlspecialchars($proyecto['precio']); ?></td>
            <td><?php echo $proyecto['entregado'] ? 'Sí' : 'No'; ?></td>
            <td class="actions">
                <a href="editar_proyecto.php?id=<?php echo $proyecto['_id']; ?>" class="button">Editar</a>
                <a href="index.php?accion=eliminar&id=<?php echo $proyecto['_id']; ?>" class="button" onclick="return confirm('¿Estás seguro de que quieres eliminar este proyecto?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <center><a href="agregar_proyecto.php" class="button">Agregar Nueva Proyecto</a></center>
</div>
</body>
</html>
