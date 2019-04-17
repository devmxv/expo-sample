<?php
require_once '../includes/init.php';

$database = new Database();

$db = $database->connect();

$marca = new Marca($db);

$marca->opciones_categoria();




?>