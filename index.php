<?php
	require_once 'includes/init.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<title>Expo TyT 2019 Demo</title>
</head>
<body>
	<!-- Header -->
	<nav class="navbar navbar-light bg-light">
	  <a class="navbar-brand" href="#">
	    <img class="d-inline-block align-top" src="img/logotipo-mini.png" alt=""/>
	  </a>
	</nav>
	<div class="container">
		<div class="row">
			<!--Formulario de búsqueda-->
			<div class="col-sm-12 titulo-sitio">
				<h3 class="text-center">Directorio de expositores</h3>
			</div>
			<div class="col-sm-12 form-espaciado">
				<form id="form-buscar" class="form" method="post" action="includes/procesar-busqueda.php" >
			  	<div class="form-group mb-2">
			  	</div>
			  	<div class="form-group mx-sm-3 mb-2" >
			  		<label for="txtExpositor" class="sr-only">Categoría</label>
			  		<!--expositor-->
			  		<select class="form-control sel-tipo" name="selTipo" required="required" id="select">
			  			<option value="marca" selected="selected">Marca</option>
			  			<option value="categoria">Categoría</option>
			  			<option value="alfabetico">Orden Alfabético</option>
			  		</select>
			  		<!--campo escondido que determina el tipo de búsqueda-->
			  		<input type="hidden" id="txtTipoBusqueda" value="1">
			  	</div>
				<!-- div que muestra la categoria a buscar-->
				<div class="form-group mx-sm-3 mb-2" id="divCategoriaBuscar">
					<label for="txtExpositor" class="sr-only">Categoría</label>
					<!--expositor-->
					<select class="form-control sel-tipo" name="selCategoria"  id="categoria">
					</select>
				</div>
			  	<div class="form-group mx-sm-3 mb-2" id="divCategoriaBuscarMarca">
			    	<label for="txtExpositor" class="sr-only">Expositor</label>
			    	<input type="text" class="form-control" name="txtExpositor" placeholder="Nombre expositor" id="textBuscaMarca" required="required">
			  	</div>
			  	<!-- div que muestra la búsqueda por orden alfabetico-->
			  	<div class="form-group mx-sm-3 mb-2" id="divCategoriaBuscarAlfabeto">
			  		<label for="txtExpositor" class="sr-only">Categoría</label>
			  		<!--rangos alfabéticos-->
			  		<select class="form-control sel-tipo" name="selAlfabeto"  id="alfabeto">
			  			<option value="0" selected="selected">Seleccione</option>
			  			<option value="1">A-I</option>
			  			<option value="2">J-R</option>
			  			<option value="3">S-Z</option>
			  		</select>
			  	</div>
			  	<button type="submit" class="btn btn-danger mb-2 but-buscar">Buscar</button>
			  	<a href="directorio.php"><p>Directorio completo de expositores</p></a>
				</form>
			</div>
		</div>
		<!-- ****** -->
		<!--listado de marcas por búsqueda-->
		<div id="lista-marcas" style="display: none;"></div>
		<!--/listado-->
		<!--Definición de div de resultado de búsqueda-->
		<div id="resultados-busqueda" style="display: none;" class="col-sm-12 block-detalle info-expositor">
			<!--Aquí se inserta contenido dinámico de búsqueda-->
		</div>
		<!--/resultados-->
		<!--Aquí se muestra div sin resultados-->
		<div id="sin-resultados" style="display: none;" class="no-resultado">
		</div>
		<!-- Div de mapa interactivo (simulado)-->
		<div id="mapa-interactivo" class="row text-center map-int">
			<div class="col-sm-12">
				<img style="padding-right: 20px;" class="responsive" src="img/mapa-og.jpg" width="350" height="350">
			</div>
		</div>
		<!--/Mapa-->
		<br/>
		<br/>
		<!--Aquí se muestra div sin resultados-->
		<div id="sin-resultados" style="display: none;" class="no-resultado"></div>

		<!-- Banner de marcas -->
		<div class="col-sm-12 banner">
			<img src="img/banner-marcas.jpg" class="img-fluid">
		</div>
	</div>
	<br/>
	<br/>
	<!-- Footer -->
	<footer class="fixed-bottom">
		<img src="img/banner-marcas.jpg" class="img-fluid">
	  <!-- Copyright -->
	  <div class="footer-copyright text-center py-3">© 2019 Copyright:
	    <a href="https://tyt.com.mx" target="_blank">Transportes y Turismo</a>
	  </div>
	  <!-- Copyright -->
	</footer>
	<!-- /Footer -->
</body>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript" src="js/procesar.js"></script>
<script type="text/javascript">
	$(function() {
		// Variable que recoge el resultado de la consulta sobre la tabla
		let opcionesMarca = [<?php require_once('controllers/opciones-marca.php') ?>];
		$("#textBuscaMarca").autocomplete({
		source: opcionesMarca
			});
		//---Hace un override al funcionamiento normal de autocomplete para que sólo encuentre por la primera
		//---letra
		$.ui.autocomplete.filter = function (array, term) {
		    let matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(term), "i");
		    return $.grep(array, function (value) {
		        return matcher.test(value.label || value.value || value);
		    });
		};
	});
</script>
</html>
