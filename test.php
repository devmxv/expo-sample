<?php

require_once 'includes/Database.php';

require_once 'includes/Marca.php';


$database = new Database();

$db = $database->connect();


$marca = new Marca($db);

$marca->tipo = 'marca';
$marca->nombre = 'Dina';
$busqueda_marca = $marca->busqueda_marca();

$detalle_marca = $busqueda_marca->fetch(PDO::FETCH_ASSOC);

echo $detalle_marca['nombre'];



// $mensaje = $marca->mensaje();

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<select>
		<option>Select Category...</option>
		<?php
			while($detalle = $opciones->fetch(PDO::FETCH_ASSOC)){
				extract($detalle);
				echo "<option value='{$idmarca}'>{$nombre}</option>";
			}
		?>
	</select>
</body>
</html>