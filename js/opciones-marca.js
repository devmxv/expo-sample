/*--------------------------------------------------------------------*/
/* opciones-marca.js - Script para poder mostrar las opciones de marca*/
/*                     por medio de jQueryUI                          */
/*--------------------------------------------------------------------*/
/* Creación: 17/01/19 Luis Martín Vázquez Gómez                       */
/*--------------------------------------------------------------------*/
$(function() {
	// Variable que recoge el resultado de la consulta sobre la tabla
	let opcionesMarca = [<?php echo $opciones ?>];
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