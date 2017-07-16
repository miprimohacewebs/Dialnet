$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
	$("#tablaPublicaciones").DataTable({
		"processing" : true,
		"serverSide" : true,
		"ajax" : "/api/publicaciones",
		"columns" : [ {
			data : 'x_idpublicacion',
			name : 'x_idpublicacion'
		}, {
			data : 'tx_titulo',
			name : 'tx_titulo'
		}, {
			data : 'tx_resumen',
			name : 'tx_resumen'
		}, {
			data : 'fh_fechapublicacion',
			name : 'fh_fechapublicacion'
		} ]
	});
	
	$("#tablaCategorias").DataTable({
		"serverSide" : false,
		"lengthChange": false,
		"info": false,
		"searching": false,
		"pageLength": 10,
		"pagingType": "simple",
		"ajax" : "/api/categorias",
		"columns" : [ {
			data : 'tx_categoria',
			"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	            $(nTd).html("<a href='#' onClick='actualizarListado(\"cat\","+oData.x_idcategoria+");' >"+oData.tx_categoria+"</a>");
			}
		} ]
	});
	
	$("#tablaAutores").DataTable({
		"serverSide" : false,
		"lengthChange": false,
		"info": false,
		"searching": false,
		"pageLength": 10,
		"pagingType": "simple",
		"ajax" : "/api/autores",
		"columns" : [ {
			data : 'tx_autor',
			"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	            $(nTd).html("<a href='#' onClick='actualizarListado(\"aut\","+oData.idAutor+");'>"+oData.tx_autor+"</a>");
			}
		} ]
	});
	
	$("#tablaAtoz").DataTable({
		"serverSide" : false,
		"lengthChange": false,
		"info": false,
		"searching": false,
		"pageLength": 27,
		"pagingType": "simple",
		"ajax" : "/api/letras",
		"columns" : [ {
			data : 'letras',
			"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	            $(nTd).html("<a href='#' onClick='actualizarListado(\"tit\",\""+oData.letras+"\");'>"+oData.letras+"</a>");
			}
		} ]
	});
	
	$('#categorias').click(function(){
	    $('#categoriasMenu').show();
	    $('#autoresMenu').hide();
	    $('#atozMenu').hide();
	});

	$('#autores').click(function(){
	    $('#categoriasMenu').hide();
	    $('#autoresMenu').show();
	    $('#atozMenu').hide();
	});
	$('#atoz').click(function(){
	    $('#categoriasMenu').hide();
	    $('#autoresMenu').hide();
	    $('#atozMenu').show();
	});
	
});

/**
 * 
 * Función que actualiza la tabla de publicaciones filtrando por el valor seleccionado.
 * Tipo: indica el tipo de filtro a realizar opciones posibles:
 * 		- cat: filtra por categorias.
 * 		- tit: filtra por primera letra del título.
 * 		- aut: filtra por el autor.
*/
function actualizarListado (tipo, valor){

	
	$("#tablaPublicaciones").DataTable().destroy();
	$("#tablaPublicaciones").empty();
	
	$("#tablaPublicaciones").DataTable({
		"processing" : true,
		"serverSide" : true,
		"ajax": {
            "url" : "/api/publicacionesFiltro",
            "type": "GET",
            "data" : {
            	"valor": valor,
            	"tipo": tipo
            }
        },
		"columns" : [ {
			data : 'x_idpublicacion',
			name : 'x_idpublicacion'
		}, {
			data : 'tx_titulo',
			name : 'tx_titulo'
		}, {
			data : 'tx_resumen',
			name : 'tx_resumen'
		}, {
			data : 'fh_fechapublicacion',
			name : 'fh_fechapublicacion'
		} ]
	});
}


