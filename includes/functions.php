<?php
require_once __DIR__ . '/../config/database.php';

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function formatDate($date) {
    return $date instanceof MongoDB\BSON\UTCDateTime ? $date->toDateTime()->format('d-m-Y') : '';
}

function crearProyecto($proyecto, $descripcion, $color, $precio, $fechaEntrega) {
    global $tasksCollection;

    // Validación de datos
    if (!is_numeric($precio)) {
        throw new InvalidArgumentException("El precio debe ser numérico.");
    }

    $fechaEntrega = new MongoDB\BSON\UTCDateTime(new DateTime($fechaEntrega));
    $entregado = false;

    $tasksCollection->insertOne([
        'proyecto' => $proyecto,
        'descripcion' => $descripcion,
        'color' => $color,
        'precio' => (float)$precio,
        'fechaEntrega' => $fechaEntrega,
        'entregado' => $entregado
    ]);
}

function obtenerProyecto() {
    global $tasksCollection;
    return $tasksCollection->find()->toArray();
}

function obtenerProyectoPorId($id) {
    global $tasksCollection;
    return $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function actualizarProyecto($id, $nombre, $descripcion, $color, $precio, $fechaEntrega, $entregado) {
    global $tasksCollection;
    $fechaEntrega = new MongoDB\BSON\UTCDateTime(new DateTime($fechaEntrega));

    $tasksCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'proyecto' => $nombre,
            'descripcion' => $descripcion,
            'color' => $color,
            'precio' => (float)$precio,
            'fechaEntrega' => $fechaEntrega,
            'entregado' => $entregado
        ]]
    );
}

function eliminarProyecto($id) {
    global $tasksCollection;
    $result = $tasksCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    return $result->getDeletedCount();
}
