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
                "lengthChange" : false,
                "language": {
                    "processing": "Procesando publicaciones...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen publicaciones.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay publicaciones disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de publicaciones)",
                    "loadingRecords": "Cargando publicaciones en curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen publicaciones disponibles.",
                    "bLengthChange" : false,
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
                },
                "columns" : [
                    {
                        data : 'tx_titulo',
                        name : 'tx_titulo',
                        sWidth : '50%'
                    },
                    {
                        data : 'tx_resumen',
                        name : 'tx_resumen',
                        sWidth : '40%'
                    },
                    {
                        data : 'x_idpublicacion',
                        sWidth : '10%',
                        mRender : function(data, type, full) {
                            return "<a href='detallePublicacion' id='"
                                + data
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>"
                                + "&nbsp;&nbsp;<a href='descargarPublicacion' id='"+data+ "' class='descargarPublicacion'  data-toggle='modal' data-target='#descargarPublicacion' title='Descargar'"
                                + " alt='Descargar'><i class='fa fa-download'></i></a>";
                        }

                    } ]
            });

    /** Modal de detalle */
    /** Modal de detalle */
    $('#verDetalle').on('show.bs.modal',function(e) {
        var $modal = $(this), idPublicacion = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'GET',
            url: '/api/verDetallePublicacion',
            data: 'idPublicacion=' + idPublicacion,
            success: function(data){
                var html=""
                if (data.publicacion) {
                    // Título
                    if(data.publicacion[0].tx_titulo){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Título:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_titulo;
                        html += "</div>";
                        html += "</div>";
                    }
                    // ISBN
                    if(data.publicacion[0].tx_isbn){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>ISBN:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_isbn;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Año
                    if(data.publicacion[0].nu_ano){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Año:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].nu_ano;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Páginas
                    if(data.publicacion[0].tx_paginas){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Páginas:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_paginas;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Edición
                    if(data.publicacion[0].tx_edicion){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Edición:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_edicion;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Resumen
                    if(data.publicacion[0].tx_resumen){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Resumen:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_edicion;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Descriptores
                    if(data.publicacion[0].tx_descriptores){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Descriptores:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_descriptores;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Subtitulo
                    if(data.publicacion[0].tx_subtitulo){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Subtítulo:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_subtitulo;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Genero
                    if(data.publicacion[0].tx_genero){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'>Genero:</div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_genero;
                        html += "</div>";
                        html += "</div>";
                    }
                    $modal.find('.edit-content').html(html);
                }else{
                    $modal.find('.edit-content').html("<div class='row'><div class='col-md-12'>"+data.msg+"</div></div>");
                }

            },

            error:function() {
                $modal.find('.edit-content').html("<div class='row'><div class='col-md-12'>Ha surgido un error al mostrar el detalle de la publicación.</div></div>");
            },
        });
    });
	$("#tablaCategorias").DataTable({
		"serverSide" : false,
		"lengthChange": false,
		"info": false,
		"searching": false,
		"pageLength": 10,
		"pagingType": "simple",
		"ajax" : "/api/categorias",
		"language": {
                    "processing": "Procesando publicaciones...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen publicaciones.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay publicaciones disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de publicaciones)",
                    "loadingRecords": "Cargando publicaciones en curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen publicaciones disponibles.",
                    "bLengthChange" : false,
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
                },
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
		"language": {
                    "processing": "Procesando publicaciones...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen publicaciones.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay publicaciones disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de publicaciones)",
                    "loadingRecords": "Cargando publicaciones en curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen publicaciones disponibles.",
                    "bLengthChange" : false,
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
                },
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
		"language": {
                    "processing": "Procesando publicaciones...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen publicaciones.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay publicaciones disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de publicaciones)",
                    "loadingRecords": "Cargando publicaciones en curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen publicaciones disponibles.",
                    "bLengthChange" : false,
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
                },
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
			"language": {
                    "processing": "Procesando publicaciones...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen publicaciones.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay publicaciones disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de publicaciones)",
                    "loadingRecords": "Cargando publicaciones en curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen publicaciones disponibles.",
                    "bLengthChange" : false,
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
                },
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


