$.ajaxSetup({
	headers : {
		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	}
});

$(function() {
	$("#tablaPublicaciones")
			.DataTable(
					{
						"processing" : true,
						"serverSide" : true,
						"ajax" : "/api/publicaciones",
						"columns" : [
                                {
                                    title: 'Título',
                                    data : 'tx_titulo',
                                    name : 'tx_titulo',
                                    sWidth : '50%'
                                },
                                {
                                    title: 'Resumen',
                                    data : 'tx_resumen',
                                    name : 'tx_resumen',
                                    sWidth : '40%'
                                },
                                {
                                    title: 'Ver detalle',
                                    data : 'x_idpublicacion',
                                    sWidth : '10%',
                                    mRender : function(data, type, full) {
                                        return "<a href='detallePublicacion' id='"
                                            + data
                                            + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>";
                                    }

                                } ]
					});

	/** Modal de detalle */
	$('#verDetalle')
			.on(
					'show.bs.modal',
					function(e) {
						var $modal = $(this), idPublicacion = e.relatedTarget.id;

                        // $.ajax({
                        // cache: false,
                        // type: 'POST',
                        // url: '/api/verDetalle',
                        // data: 'idPublicacion=' + idPublicacion,
                        // success: function(data) {
                        // $modal.find('.edit-content').html(data);
                        // });
                        $modal
                            .find('.edit-content')
                            .html(
                                "<div class='row'><div class='col-md-3'>Título:</div><div class='col-md-9'>Prueba de título</div></div>" +
                                "<div class='row'><div class='col-md-3'>Resumen:</div><div class='col-md-9'>Prueba de resumen</div></div>" +
                                "<div class='row'><div class='col-md-3'>Prueba:</div><div class='col-md-9'>bla bla bla bla bla</div></div>" +
                                "<div class='row'><div class='col-md-3'>Prueba:</div><div class='col-md-9'>bla bla bla bla bla</div></div>" +
                                "<div class='row'><div class='col-md-3'>Prueba:</div><div class='col-md-9'>bla bla bla bla bla</div></div>" +
                                "<div class='row'><div class='col-md-3'>Prueba:</div><div class='col-md-9'>bla bla bla bla bla</div></div>");
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
		"columns" : [
            {
                title: 'Título',
                data : 'tx_titulo',
                name : 'tx_titulo',
                sWidth : '50%'
            },
            {
                title: 'Resumen',
                data : 'tx_resumen',
                name : 'tx_resumen',
                sWidth : '40%'
            },
            {
                title: 'Ver detalle',
                data : 'x_idpublicacion',
                sWidth : '10%',
                mRender : function(data, type, full) {
                    return "<a href='detallePublicacion' id='"
                        + data
                        + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>";
                }

            }
        ]
	});
}


