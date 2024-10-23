<?php
require_once __DIR__ . '/../vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb+srv://dsi4:abdiel123@cluster0.jc01z.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
$database = $mongoClient->selectDatabase('tienda');
$tasksCollection = $database->trabajos;

?>