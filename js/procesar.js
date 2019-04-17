/*-------------------------------------------------------------------------*/
/* procesar.js - Archivo javascript que procesa búsquedas y resultados de  */
/*               búsquedas en base de datos por AJAX/jQuery                */
/*-------------------------------------------------------------------------*/
/* Autor: Luis Martín Vázquez Gómez (BasicoFM)                             */
/*-------------------------------------------------------------------------*/
/* Fecha creación: 10-Diciembre-2018                                       */
/*-------------------------------------------------------------------------*/

$(document).ready(function(){
	//---Esconder opciones de búsqueda cuando se inicia el sitio
	$('#divCategoriaBuscar').hide();
	$('#divCategoriaBuscarAlfabeto').hide();
	//---acciones al mandar el formulario
	$('#form-buscar').submit(function(event) {
		//---obtener datos de form
		// var selAlfa = $('select[name=selAlfabeto]').val();
		var tipo = $('#txtTipoBusqueda').val();
		//---si valor de rango es != 0 se usa un valor diferente de formData
		if(tipo == 1){
			var formData = {
				'tipo' : $('select[name=selTipo]').val(),
				'expositor' : $('input[name=txtExpositor]').val()
			}
		}
		if(tipo == 2){
			var formData = {
					'categoria': $('select[name=selCategoria').val()
			}
		}
		if(tipo == 3){
			var formData = {
				'alfabetico': $('select[name=selAlfabeto').val()
			};	
		}

		//---procesar form
		$.ajax({
			type: 'POST',
			url: 'controllers/procesar-busqueda.php',
			data: formData,
			dataType: 'json',
			encode: true
		})
		.done(function(data){
			console.log(data);
			//---si se procesa la info, se mostraría div de detalle
			mostrarDatosBusqueda(data);
		})

		.fail(function(data){
			console.log(data);
		});

		//---evitar que form envíe datos y refrescar página
		event.preventDefault();
	});

	//seleccionar si es marca, categoría o búsqueda alfabética
	$('#select').on('change',function(){
			 var optionText = $("#select option:selected").val();
			 switch(optionText){
			 	case "categoria":
			 		$('#divCategoriaBuscar').show();
			 		$('#divCategoriaBuscarMarca').hide();
			 		$('#divCategoriaBuscarAlfabeto').hide();
			 		CargarProductos();
			 		$("#categoria").prop('required',true);
			 		$('#textBuscaMarca').prop('required',false);
			 		//---se define el valor para poder determinar el tipo de búsqueda
			 		$('#txtTipoBusqueda').val(2);
			 		//---se esconde la tabla de resultados de búsqueda
			 		$('#lista-marcas').hide();
			 		//---restablecer imagen de mapa al reiniciar la búsqueda
			 		$('#mapa-interactivo').html('<div class="col-sm-12"><img class="responsive" src="img/mapa-og.jpg" width="350" height="350"></div>');
			 		//---esconder div de detalle de búsqueda cuando se ha mostrado
			 		$('#resultados-busqueda').hide();
			 		//---limpiar campo de marca cuando se busca algo
			 		$('#textBuscaMarca').val('');
			 		break;
			 	case "marca":
			 		$('#divCategoriaBuscar').hide();
			 		$('#divCategoriaBuscarMarca').show();
			 		$('#divCategoriaBuscarAlfabeto').hide();
			 		$("#categoria").prop('required',false);
			 		$('#textBuscaMarca').prop('required',true);
			 		$('#txtTipoBusqueda').val(1);
			 		//---se esconde la tabla de resultados de búsqueda
			 		$('#lista-marcas').hide();
			 		//---se esconde la tabla de resultados de búsqueda
			 		$('#resultados-busqueda').hide();
			 		//---limpiar campo de marca cuando se busca algo
			 		$('#textBuscaMarca').val('');
			 		//---restablecer imagen de mapa al reiniciar la búsqueda
			 		$('#mapa-interactivo').html('<div class="col-sm-12"><img class="responsive" src="img/mapa-og.jpg" width="350" height="350"></div>');
			 		break;
			 	case "alfabetico":
			 		$('#divCategoriaBuscar').hide();
			 		$('#divCategoriaBuscarMarca').hide();
			 		$('#divCategoriaBuscarAlfabeto').show();
			 		$("#categoria").prop('required',false);
			 		// $('#textBuscaMarca').prop('required',true);
			 		$('#textBuscaMarca').prop('required',false);
			 		$('#txtTipoBusqueda').val(3);
			 		//---esconder tabla de resultados
			 		$('#lista-marcas').hide();
			 		//---esconder div de detalle de resultados de búsqueda
			 		$('#resultados-busqueda').hide();
			 		//---restablecer imagen de mapa al reiniciar la búsqueda
			 		$('#mapa-interactivo').html('<div class="col-sm-12"><img class="responsive" src="img/mapa-og.jpg" width="350" height="350"></div>');
			 		break;
			 }
			 // if(optionText=="categoria")
			 // {
				// $('#divCategoriaBuscar').show();
				// $('#divCategoriaBuscarMarca').hide();
				// CargarProductos();
 			// 	$("#categoria").prop('required',true);
				// $('#textBuscaMarca').prop('required',false);
			 // }else {
				// $('#divCategoriaBuscar').hide();
				// $('#divCategoriaBuscarMarca').show();
				// $("#categoria").prop('required',false);
				// $('#textBuscaMarca').prop('required',true);
			 // }
	 });

});

/*-----------------------------------------------------------------------*/
/* busquedaTabla(id) - Función para obtener el detalle del id de marca   */
/*                     una vez seleccionandolo                           */
/*-----------------------------------------------------------------------*/
function busquedaTabla(id){
	$.ajax({
		type: "GET",
		url: 'includes/procesar-busqueda-tabla.php?id=' + id,
		// data: id,
		dataType: 'json',
		encode: true
	})
	.done(function(data){
		var id_marca = '#valor-exp-17';
		//---llevar a div de detalle de expositor
		// $("#valor-exp").click(function(){            
		$(id_marca).click(function(){            
		    $('html, body').animate({
		            scrollTop: $("#resultados-busqueda").offset().top
		        }, 500);
		});
		mostrarDatosBusqueda(data);
		const idResultados = 'resultados-busqueda';
		desplazar(idResultados);
		
	})
	.fail(function(data){
		console.log(data);
	});

	//---evitar que form envíe datos y refrescar página
	event.preventDefault();
}


/*------------------------------------------------------------------------------*/
/* mostrarDatosBusqueda() - Función que muestra los datos procesados            */
/*------------------------------------------------------------------------------*/
function mostrarDatosBusqueda(data){
	//---se regresa 'marca' para determinar que sea una búsqueda simple
	if(data.success == true && data.message == 'marca'){
		console.log(data.marca);
		//---Mostrar imagen de ubicación del expositor
		$('#mapa-interactivo').html(
			'<div class="col-sm-12"><img class="responsive" src="/img/'+ data.ruta + '" width="350" height="350"></div>'
			);
		$('#resultados-busqueda').show();
		//---se agrega contenido dinámico a div de resultados procesados
		$('#resultados-busqueda').html(
			'<img class="img-logo-exp responsive" src="/marcas_logos/'+ data.logo +'">' +
			'<h3>' + data.nombre + '</h3>' +
			'<p><strong>Stand: </strong>' + data.stand + '</h3>' +
			'<p><strong>Categoría:</strong> ' + data.categoria + '</p>' + 
			'<p><strong>Dirección:</strong> ' + data.direccion + '</p>' +
			'<p><strong>Teléfono:</strong> ' + data.telefono + '</p>' +
			'<p><strong>Contacto:</strong> ' + data.contacto + '</p>'
			);
		$('#resultados-busqueda').scrollTop();
		// var selAlfa = 0;
		//---si es una búsqueda por rango del alfabeto
		} else if(data.success = true && data.message == 'lista' ){
			$('#lista-marcas').html(
				'<table class="table tabla-lista"><thead><th>Marca</th></thead><tbody>'
				 + data.output + 
				'</tbody></table>'
				);
			$('#lista-marcas').show();
			//---resuelve problema de símbolo , mostrado en tabla de resultados
			var div = $('#lista-marcas');
			div.html(div.html().replace(/\,/g, ''));
			// //---llevar a div de detalle de expositor
			// $("#valor-exp").click(function(){            
			//     $('html, body').animate({
			//             scrollTop: $("#resultados-busqueda").offset().top
			//         }, 500);
			// });
		} else { //---si no hay resultados se muestra mensaje
			$('#sin-resultados').show();
			$('#sin-resultados').html(
					'<p>Sin resultados</p>'
				);
			$('#resultados-busqueda').hide();
			setTimeout(function() {
			  // const idResultados = 'sin-resultados';
			  // desplazar(idResultados);
			  $('#sin-resultados').fadeOut('fast');
			}, 4000);
		}
	// var selAlfa = 0;
}



//---Abraham
function CargarProductos()
{
		 $.ajax({
				 type: "POST",
				 url: 'controllers/consulta-cat.php',
				 success: function(resp){
						 $('#categoria').html(resp);
				 }
		 });
 }


//--------------------------------------------------------------
// desplazar() - Una vez que se encuentra se desplaza a         
//               resultados de búsqueda
//--------------------------------------------------------------
function desplazar(idDiv){
	let elemento = document.getElementById(idDiv);
	elemento.scrollIntoView();
}