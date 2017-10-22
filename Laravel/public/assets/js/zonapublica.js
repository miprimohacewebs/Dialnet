$.ajaxSetup({
	headers : {
		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	}
});
/** Constantes */
var RUTA_IMAGENES = 'assets/images/imagesPublicaciones/';

/** Carga de tabla publicaciones */
$(function() {
    $("#tablaPublicaciones")
        .DataTable(
            {
               // "dom": '<"top"i>rt<"bottom"flp><"clear">',
                "processing" : true,
                "serverSide" : true,
                "ajax" : "/api/publicaciones",
                "lengthChange" : true,
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
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
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
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>"
                                + "&nbsp;&nbsp;<a href='descargarPublicacion' id='"+data+ "' class='descargarPublicacion'  data-toggle='modal' data-target='#descargarPublicacion' title='Descargar'"
                                + " alt='Descargar'><i class='fa fa-download'></i></a>";
                        }

                    } ]
            });


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
                  html +="<div class='row'>";
                    html += "<div class='col-md-3'><img src='" + data.publicacion[0].tx_imagen + "'  class='img-responsive' /></div><div class='col-md-9'>";
                    // Título
                    if(data.publicacion[0].tx_titulo){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Título:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_titulo;
                        html += "</div>";
                        html += "</div>";
                    }
                    // ISBN
                    if(data.publicacion[0].tx_isbn){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>ISBN:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_isbn;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Año
                    if(data.publicacion[0].nu_ano){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Año:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].nu_ano;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Páginas
                    if(data.publicacion[0].tx_paginas){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Páginas:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_paginas;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Edición
                    if(data.publicacion[0].tx_edicion){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Edición:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_edicion;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Obra
                    if(data.publicacion[0].tx_obra){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Obra:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_obra;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Resumen
                    if(data.publicacion[0].tx_resumen){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Resumen:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_edicion;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Descriptores
                    if(data.publicacion[0].tx_descriptores){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Descriptores:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_descriptores;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Imágen
                    if(data.publicacion[0].tx_imagen){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Imagen:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_imagen;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Subtitulo
                    if(data.publicacion[0].tx_subtitulo){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Subtítulo:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_subtitulo;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Genero
                    if(data.publicacion[0].tx_genero){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Genero:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_genero;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Asunto
                    if(data.publicacion[0].tx_asunto){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Asunto:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_asunto;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Fecha de publicación
                    if(data.publicacion[0].fh_fechapublicacion){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Fecha de publicación:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].fh_fechapublicacion;
                        html += "</div>";
                        html += "</div>";
                    }
                    // País
                    if(data.publicacion[0].tx_pais){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>País:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_pais;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Idioma
                    if(data.publicacion[0].tx_idioma){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Idioma:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_idioma;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Número de páginas
                    if(data.publicacion[0].nu_numPaginas){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Número de páginas:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].nu_numPaginas;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Categoría
                    if(data.publicacion[0].tx_categoria){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Categoría:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_categoria;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Autores
                    if(data.publicacion[0].autores){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Autores/as:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].autores;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Editores
                    if(data.publicacion[0].editores){
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Editores/as:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].editores;
                        html += "</div>";
                        html += "</div>";
                    }
                    html += "</div>";
                    html += "</div>";
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
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen categorías.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay categorías disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de categorías)",
                    "loadingRecords": "En curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen categorías disponibles.",
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    }
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
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen autores.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay autores disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de autores)",
                    "loadingRecords": "En curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen autores disponibles.",
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    }
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
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen publicaciones.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay publicaciones disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de publicaciones)",
                    "loadingRecords": "En curso...",
                    "infoPostFix": "",
                    "emptyTable": "No existen publicaciones disponibles.",
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    }
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


    $("#tablaPublicaciones")
        .DataTable(
            {
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
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
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
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>"
                                + "&nbsp;&nbsp;<a href='descargarPublicacion' id='"+data+ "' class='descargarPublicacion'  data-toggle='modal' data-target='#descargarPublicacion' title='Descargar'"
                                + " alt='Descargar'><i class='fa fa-download'></i></a>";
                        }

                    } ]
            });
}

/**
 *
 * Función que resetea la pantalla pública de la aplicación.
 * Acciones que realiza:
 * - Resetea el listado de publicaciones para que no contenga ningún filtro.
 * - Oculta los filtros del menú lateral.
 */
function resetearPantalla(){

    $('#categoriasMenu').hide();
    $('#autoresMenu').hide();
    $('#atozMenu').hide();

    $("#tablaPublicaciones").DataTable().destroy();
    $("#tablaPublicaciones").empty();

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
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    },
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
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>"
                                + "&nbsp;&nbsp;<a href='descargarPublicacion' id='"+data+ "' class='descargarPublicacion'  data-toggle='modal' data-target='#descargarPublicacion' title='Descargar'"
                                + " alt='Descargar'><i class='fa fa-download'></i></a>";
                        }

                    } ]
            });
}


