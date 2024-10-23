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
        throw new InvalidArgumentException("El precio debe ser un número.");
    }

    $resultado = $tasksCollection->insertOne([
        'proyecto' => sanitizeInput($proyecto),
        'descripcion' => sanitizeInput($descripcion),
        'color' => sanitizeInput($color),
        'precio' => sanitizeInput($precio),
        'fechaEntrega' => new MongoDB\BSON\UTCDateTime(strtotime($fechaEntrega) * 1000),
        'entregado' => false
    ]);
    return $resultado->getInsertedId();
}

function obtenerProyecto() {
    global $tasksCollection;
    return $tasksCollection->find();
}

function obtenerProyectoPorId($id) {
    global $tasksCollection;
    return $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function actualizarProyecto($id, $proyecto, $descripcion, $color, $precio, $fechaEntrega, $entregado) {
    global $tasksCollection;

    if (!is_numeric($precio)) {
        throw new InvalidArgumentException("El precio debe ser un número.");
    }

    // Validar formato de fecha
    $fecha = DateTime::createFromFormat('d-m-Y', $fechaEntrega);
    if (!$fecha) {
        throw new InvalidArgumentException("La fecha de entrega no es válida.");
    }

    $resultado = $tasksCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'proyecto' => sanitizeInput($proyecto),
            'descripcion' => sanitizeInput($descripcion),
            'color' => sanitizeInput($color),
            'precio' => sanitizeInput($precio),
            'fechaEntrega' => new MongoDB\BSON\UTCDateTime($fecha->getTimestamp() * 1000),
            'entregado' => $entregado
        ]]
    );
    return $resultado->getModifiedCount();
}


function eliminarProyecto($id) {
    global $tasksCollection;
    $resultado = $tasksCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    return $resultado->getDeletedCount();
}
?>
