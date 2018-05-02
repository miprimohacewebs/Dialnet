$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/** Constantes */
var RUTA_IMAGENES = 'assets/images/imagesPublicaciones/';



/** Carga de tabla publicaciones */
$(function () {


    jQuery.fn.DataTable.ext.type.search.string = function (data) {
        return !data ?
            '' :
            typeof data === 'string' ?
                data
                    .replace(/έ/g, 'ε')
                    .replace(/[ύϋΰ]/g, 'υ')
                    .replace(/ό/g, 'ο')
                    .replace(/ώ/g, 'ω')
                    .replace(/ά/g, 'α')
                    .replace(/[ίϊΐ]/g, 'ι')
                    .replace(/ή/g, 'η')
                    .replace(/\n/g, ' ')
                    .replace(/á/g, 'a')
                    .replace(/é/g, 'e')
                    .replace(/í/g, 'i')
                    .replace(/ó/g, 'o')
                    .replace(/ú/g, 'u')
                    .replace(/ê/g, 'e')
                    .replace(/î/g, 'i')
                    .replace(/ô/g, 'o')
                    .replace(/è/g, 'e')
                    .replace(/ï/g, 'i')
                    .replace(/ü/g, 'u')
                    .replace(/ã/g, 'a')
                    .replace(/õ/g, 'o')
                    .replace(/ç/g, 'c')
                    .replace(/ì/g, 'i') :
                data;
    };


    /** Modal de detalle */
    $('#verDetalle').on('show.bs.modal', function (e) {
        var $modal = $(this), idPublicacion = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'GET',
            url: '/api/verDetallePublicacion',
            data: 'idPublicacion=' + idPublicacion,
            success: function (data) {
                var html = "";
                if (data.publicacion) {
                    html += "<div class='row'>";
                    html += "<div class='col-md-3'><img src='" + data.publicacion[0].tx_imagen + "' onerror=\"this.src='assets/images/imagesPublicaciones/imgTemplate.jpg'\"  class='img-responsive' /></div><div class='col-md-9'>";
                    // Título
                    if (data.publicacion[0].tx_titulo) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Título:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_titulo;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Autores
                    if (data.publicacion[0].autores) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Autores/as:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].autores;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Resumen
                    if (data.publicacion[0].tx_resumen) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Resumen:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_resumen;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Etiquetas
                    if (data.publicacion[0].tx_descriptores) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Etiquetas:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_descriptores;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Publicación
                    if (data.publicacion[0].tx_publicacion) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Publicación:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_publicacion;
                        html += "</div>";
                        html += "</div>";
                    }
                    // DOI
                    if (data.publicacion[0].tx_doi) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>DOI:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_doi;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Enlace al texto DOI
                    if (data.publicacion[0].tx_enlacedoi) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Enlace al texto:</strong></div>";
                        html += "<div class='col-md-9' style='text-overflow: ellipsis; overflow: hidden; white-space: nowrap;'><a href='" + data.publicacion[0].tx_enlacedoi + "' target='_blank'>";
                        html += data.publicacion[0].tx_enlacedoi;
                        html += "</a>"
                        html += "</div>";
                        html += "</div>";
                    }
                    // ISBN
                    if (data.publicacion[0].tx_isbn) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>ISBN/ISSN:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_isbn;
                        html += "</div>";
                        html += "</div>";
                    }
                     // Fecha de publicación
                     if (data.publicacion[0].fh_fechapublicacion) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Fecha de publicación:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].fh_fechapublicacion;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Año
                    if (data.publicacion[0].nu_ano && data.publicacion[0].nu_ano !== "0") {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Año:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].nu_ano;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Páginas
                    if (data.publicacion[0].tx_paginas) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Páginas:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_paginas;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Edición
                    if (data.publicacion[0].tx_editorial) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Editorial:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_editorial;
                        html += "</div>";
                        html += "</div>";
                    }




                    // Imagen
                    /*
                     if(data.publicacion[0].tx_imagen){
                     html += "<div class='row'>";
                     html += "<div class='col-md-3'><strong>Imagen:</strong></div>";
                     html += "<div class='col-md-9'>";
                     html += data.publicacion[0].tx_imagen;
                     html += "</div>";
                     html += "</div>";
                     }
                     */


                    // Asunto
                    /*
                     if(data.publicacion[0].tx_asunto){
                     html += "<div class='row'>";
                     html += "<div class='col-md-3'><strong>Asunto:</strong></div>";
                     html += "<div class='col-md-9'>";
                     html += data.publicacion[0].tx_asunto;
                     html += "</div>";
                     html += "</div>";
                     }
                     */
                   
                    // País
                    if (data.publicacion[0].tx_pais) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Lugar de edición:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_pais;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Idioma
                    if (data.publicacion[0].tx_idioma) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Idioma:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_idioma;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Número de páginas
                    if (data.publicacion[0].nu_numPaginas) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Número de páginas:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].nu_numPaginas;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Categoría
                    if (data.publicacion[0].tx_categoria) {
                        html += "<div class='row'>";
                        html += "<div class='col-md-3'><strong>Categoría:</strong></div>";
                        html += "<div class='col-md-9'>";
                        html += data.publicacion[0].tx_categoria;
                        html += "</div>";
                        html += "</div>";
                    }
                    // Editores
                    if (data.publicacion[0].editores) {
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
                } else {
                    $modal.find('.edit-content').html("<div class='row'><div class='col-md-12'>" + data.msg + "</div></div>");
                }

            },

            error: function () {
                $modal.find('.edit-content').html("<div class='row'><div class='col-md-12'>Ha surgido un error al mostrar el detalle de la publicación.</div></div>");
            }
        });
    });
    $("#autoresMenu").hide();
    $("#descriptoresMenu").hide();
    $("#annosMenu").hide();
    $("#categoriasMenu").hide();
    $("#divPublicaciones").hide();
    $("#divUtilidades").hide();
    // Deseleccionado - fa-square-o
    // Seleccionado - fa-check-square-o

}

);

/**
 *
 * Función que actualiza la tabla de publicaciones filtrando por los valores seleccionado.
 * Tipo: indica el tipo de valor seleccionado actualmente a realizar opciones posibles:
 *        - cat: categoria.
 *        - anno: año de publicación.
 *        - aut: autor.
 *        - desc: descriptor
 */
function actualizarListado(tipo, valor, tipoBusqueda) {

    $("#autoresMenu").show();
    $("#descriptoresMenu").show();
    $("#annosMenu").show();
    $("#categoriasMenu").show();
    $("#divPublicaciones").show();
    $("#divUtilidades").show();
    var textoBusqueda = '';
    if (tipoBusqueda === 0) {
        textoBusqueda = $("#textoBusqueda");
    } else if (tipoBusqueda === 1) {
        textoBusqueda = $("#textoBusquedaAutores");
    } else if (tipoBusqueda === 2){
        textoBusqueda = $("#textoBusquedaEtiquetas");
    } else if (tipoBusqueda === 3){
        textoBusqueda = $("#textoBusquedaAnos");
    }

    var autoresSeleccionados = $("#autoresSeleccionados").val();
    var annosSeleccionados = $("#annosSeleccionados").val();
    var categoriasSeleccionadas = $("#categoriasSeleccionadas").val();
    var descriptoresSeleccionados = $("#descriptoresSeleccionados").val();

    if (tipo === 'cat') {
        if (categoriasSeleccionadas.indexOf(',' + valor + ',') !== -1) {
            categoriasSeleccionadas = categoriasSeleccionadas.replace(valor + ',', '');
        } else if (categoriasSeleccionadas.indexOf(valor + ',') !== -1) {
            categoriasSeleccionadas = categoriasSeleccionadas.replace(valor + ',', '');
        } else if (categoriasSeleccionadas.indexOf(',' + valor) !== -1) {
            categoriasSeleccionadas = categoriasSeleccionadas.replace(',' + valor, '');
        } else if (categoriasSeleccionadas.indexOf(valor) !== -1) {
            categoriasSeleccionadas = categoriasSeleccionadas.replace(valor, '');
        } else {
            if (categoriasSeleccionadas !== '') {
                categoriasSeleccionadas = categoriasSeleccionadas + ',';
            }
            categoriasSeleccionadas = categoriasSeleccionadas + valor;
        }

        $("#categoriasSeleccionadas").val(categoriasSeleccionadas);
    } else if (tipo === 'anno') {
        if (annosSeleccionados.indexOf(',' + valor + ',') !== -1) {
            annosSeleccionados = annosSeleccionados.replace(valor + ',', '');
        } else if (annosSeleccionados.indexOf(valor + ',') !== -1) {
            annosSeleccionados = annosSeleccionados.replace(valor + ',', '');
        } else if (annosSeleccionados.indexOf(',' + valor) !== -1) {
            annosSeleccionados = annosSeleccionados.replace(',' + valor, '');
        } else if (annosSeleccionados.indexOf(valor) !== -1) {
            annosSeleccionados = annosSeleccionados.replace(valor, '');
        } else {
            if (annosSeleccionados !== '') {
                annosSeleccionados = annosSeleccionados + ',';
            }
            annosSeleccionados = annosSeleccionados + valor;
        }
        $("#annosSeleccionados").val(annosSeleccionados);
    } else if (tipo === 'aut') {
        if (autoresSeleccionados.indexOf(',' + valor + ',') !== -1) {
            autoresSeleccionados = autoresSeleccionados.replace(valor + ',', '');
        } else if (autoresSeleccionados.indexOf(valor + ',') !== -1) {
            autoresSeleccionados = autoresSeleccionados.replace(valor + ',', '');
        } else if (autoresSeleccionados.indexOf(',' + valor) !== -1) {
            autoresSeleccionados = autoresSeleccionados.replace(',' + valor, '');
        } else if (autoresSeleccionados.indexOf(valor) !== -1) {
            autoresSeleccionados = autoresSeleccionados.replace(valor, '');
        } else {
            if (autoresSeleccionados !== '') {
                autoresSeleccionados = autoresSeleccionados + ',';
            }
            autoresSeleccionados = autoresSeleccionados + valor;
        }
        $("#autoresSeleccionados").val(autoresSeleccionados);
    } else if (tipo === 'desc') {
        if (descriptoresSeleccionados.indexOf(',' + valor + ',') !== -1) {
            descriptoresSeleccionados = descriptoresSeleccionados.replace(valor + ',', '');
        } else if (descriptoresSeleccionados.indexOf(valor + ',') !== -1) {
            descriptoresSeleccionados = descriptoresSeleccionados.replace(valor + ',', '');
        } else if (descriptoresSeleccionados.indexOf(',' + valor) !== -1) {
            descriptoresSeleccionados = descriptoresSeleccionados.replace(',' + valor, '');
        } else if (descriptoresSeleccionados.indexOf(valor) !== -1) {
            descriptoresSeleccionados = descriptoresSeleccionados.replace(valor, '');
        } else {
            if (descriptoresSeleccionados !== '') {
                descriptoresSeleccionados = descriptoresSeleccionados + ',';
            }
            descriptoresSeleccionados = descriptoresSeleccionados + valor;
        }
        $("#descriptoresSeleccionados").val(descriptoresSeleccionados);
    }



    var tablaCategorias = $("#tablaCategorias");
    if ($.fn.DataTable.isDataTable('#tablaCategorias')) {
        tablaCategorias.DataTable().destroy();
        tablaCategorias.empty();
    }
    tablaCategorias.DataTable({
        "serverSide": false,
        "lengthChange": false,
        "info": false,
        "searching": false,
        "pageLength": 10,
        "pagingType": "simple",
        "ajax": {
            "url": "/api/categorias",
            "type": "GET",
            "data": {
                "autores": autoresSeleccionados,
                "descriptores": descriptoresSeleccionados,
                "categorias": categoriasSeleccionadas,
                "annos": annosSeleccionados,
                "busqueda": textoBusqueda.val(),
                "tipoBusqueda": tipoBusqueda
            }
        },
        "language": {
            "processing": "Procesando...",
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página.",
            "zeroRecords": "No se han encontrado categorías con los filtros seleccionados.",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No hay categorías disponibles",
            "infoFiltered": "(Filtrados _MAX_ del total de categorías)",
            "loadingRecords": "En curso...",
            "infoPostFix": "",
            "emptyTable": "No se han encontrado categorías con los filtros seleccionados.",
            "paginate": {
                "first": "Primero",
                "previous": "Anterior",
                "next": "Siguiente",
                "last": "Último"
            }
        },
        "columns": [{
            data: 'nombre',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                var categorias = $("#categoriasSeleccionadas").val().split(',');
                if (categorias.indexOf(String(oData.id)) >= 0) {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"cat\", " + oData.id + ")'> <i class='fa fa-check-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                } else {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"cat\", " + oData.id + ")'> <i class='fa fa-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }

            }
        }]
    });


    var tablaAutores = $("#tablaAutores");
    if ($.fn.DataTable.isDataTable('#tablaAutores')) {
        tablaAutores.DataTable().destroy();
        tablaAutores.empty();
    }
    tablaAutores.DataTable({
        "serverSide": false,
        "lengthChange": false,
        "info": false,
        "searching": false,
        "pageLength": 10,
        "pagingType": "simple",
        "ajax": {
            "url": "/api/autores",
            "type": "GET",
            "data": {
                "autores": autoresSeleccionados,
                "descriptores": descriptoresSeleccionados,
                "categorias": categoriasSeleccionadas,
                "annos": annosSeleccionados,
                "busqueda": textoBusqueda.val(),
                "tipoBusqueda": tipoBusqueda
            }
        },
        "language": {
            "processing": "Procesando...",
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página.",
            "zeroRecords": "No existen autores.",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No se han encontrado autores con los filtros seleccionados.",
            "infoFiltered": "(Filtrados _MAX_ del total de autores)",
            "loadingRecords": "En curso...",
            "infoPostFix": "",
            "emptyTable": "No se han encontrado autores con los filtros seleccionados.",
            "paginate": {
                "first": "Primero",
                "previous": "Anterior",
                "next": "Siguiente",
                "last": "Último"
            }
        },
        "columns": [{
            data: 'nombre',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                var autores = $("#autoresSeleccionados").val().split(',');
                if (autores.indexOf(String(oData.id)) >= 0) {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"aut\", " + oData.id + ")'><i class='fa fa-check-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                } else {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"aut\", " + oData.id + ")'><i class='fa fa-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }

            }
        }]
    });

    var tablaDescriptores = $("#tablaDescriptores");
    if ($.fn.DataTable.isDataTable('#tablaDescriptores')) {
        tablaDescriptores.DataTable().destroy();
        tablaDescriptores.empty();
    }
    tablaDescriptores.DataTable({
        "serverSide": false,
        "lengthChange": false,
        "info": false,
        "searching": false,
        "pageLength": 10,
        "pagingType": "simple",
        "ajax": {
            "url": "/api/descriptores",
            "type": "GET",
            "data": {
                "autores": autoresSeleccionados,
                "descriptores": descriptoresSeleccionados,
                "categorias": categoriasSeleccionadas,
                "annos": annosSeleccionados,
                "busqueda": textoBusqueda.val(),
                "tipoBusqueda": tipoBusqueda
            }
        },
        "language": {
            "processing": "Procesando...",
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página.",
            "zeroRecords": "No se han encontrado descriptores con los filtros seleccionados.",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No hay autores disponibles",
            "infoFiltered": "(Filtrados _MAX_ del total de autores)",
            "loadingRecords": "En curso...",
            "infoPostFix": "",
            "emptyTable": "No se han encontrado descriptores con los filtros seleccionados.",
            "paginate": {
                "first": "Primero",
                "previous": "Anterior",
                "next": "Siguiente",
                "last": "Último"
            }
        },
        "columns": [{
            data: 'nombre',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                var descriptores = $("#descriptoresSeleccionados").val().split(',');
                if (descriptores.indexOf(String(oData.id)) >= 0) {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"desc\", " + oData.id + ")'><i class='fa fa-check-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                } else {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"desc\", " + oData.id + ")'><i class='fa fa-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }
            }
        }]
    });


    var tablaAnnos = $("#tablaAnnos");
    if ($.fn.DataTable.isDataTable('#tablaAnnos')) {
        tablaAnnos.DataTable().destroy();
        tablaAnnos.empty();
    }
    tablaAnnos.DataTable({
        "serverSide": false,
        "lengthChange": false,
        "info": false,
        "searching": false,
        "pageLength": 10,
        "pagingType": "simple",
        "ajax": {
            "url": "/api/annos",
            "type": "GET",
            "data": {
                "autores": autoresSeleccionados,
                "descriptores": descriptoresSeleccionados,
                "categorias": categoriasSeleccionadas,
                "annos": annosSeleccionados,
                "busqueda": textoBusqueda.val(),
                "tipoBusqueda": tipoBusqueda
            }
        },
        "language": {
            "processing": "Procesando...",
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página.",
            "zeroRecords": "No se han encontrado años con los filtros seleccionados.",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No hay autores disponibles",
            "infoFiltered": "(Filtrados _MAX_ del total de autores)",
            "loadingRecords": "En curso...",
            "infoPostFix": "",
            "emptyTable": "No se han encontrado años con los filtros seleccionados.",
            "paginate": {
                "first": "Primero",
                "previous": "Anterior",
                "next": "Siguiente",
                "last": "Último"
            }
        },
        "columns": [{
            data: 'nombre',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                var annos = $("#annosSeleccionados").val().split(',');
                if (annos.indexOf(String(oData.id)) >= 0) {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"anno\", " + oData.id + ")'><i class='fa fa-check-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                } else {
                    $(nTd).html("<a href='#' onclick='actualizarListado(\"anno\", " + oData.id + ")'><i class='fa fa-square-o'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }

            }
        }]
    });

    var tablaPublicaciones = $("#tablaPublicaciones");
    if ($.fn.DataTable.isDataTable('#tablaPublicaciones')) {
        tablaPublicaciones.DataTable().destroy();
        tablaPublicaciones.empty();
    }
    tablaPublicaciones
        .DataTable(
            {
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    "url": "/api/publicaciones",
                    "type": "GET",
                    "data": {
                        "autores": autoresSeleccionados,
                        "descriptores": descriptoresSeleccionados,
                        "categorias": categoriasSeleccionadas,
                        "annos": annosSeleccionados,
                        "busqueda": textoBusqueda.val(),
                        "tipoBusqueda": tipoBusqueda
                    }
                },
                "pageLength": 20,
                "lengthChange": true,
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
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Último"
                    }
                },
                "columns": [{
                    title: 'Publicación',
                    data: 'tx_titulo',
                    data: 'tx_isbn',
                    data: 'nu_anno',
                    data: 'tx_publicacion',
                    data: 'x_idpublicacion',
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var bufferSalida = "";
                        if (oData.tx_titulo != null) {
                            bufferSalida += "<strong style ='color: #ba0600; font-family: 'Josefin Sans', sans-serif;'> <i class='fa fa-angle-right'></i> " + oData.tx_titulo + "</strong>";
                        }
                        if (oData.tx_isbn != null) {
                            bufferSalida += "<strong style ='font-family: 'Josefin Sans', sans-serif;'> ISBN/ISSN: </strong>" + oData.tx_isbn;
                        }
                        if (oData.nu_anno != null) {
                            bufferSalida += "<strong style ='font-family: 'Josefin Sans', sans-serif;'> AÑO: </strong>" + oData.nu_anno;
                        }
                        if (oData.tx_publicacion != null) {
                            bufferSalida += "<strong style ='font-family: 'Josefin Sans', sans-serif;'> PUBLICACIÓN: </strong>" + oData.tx_publicacion;
                        }
                        // Ver detalle
                        bufferSalida += " <a href='detallePublicacion' id='" + oData.x_idpublicacion + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>";

                        $(nTd).html(bufferSalida);
                    }

                }]
            });
}

/**
 *
 * Función que resetea la pantalla pública de la aplicación.
 * Acciones que realiza:
 * - Resetea el listado de publicaciones para que no contenga ningún filtro.
 * - Oculta los filtros del menú lateral.
 */
function resetearPantalla() {

    var tablaPublicaciones = $("#tablaPublicaciones");
    tablaPublicaciones.DataTable().destroy();
    tablaPublicaciones.empty();
    var tablaAnnos = $("#tablaAnnos");
    tablaAnnos.DataTable().destroy();
    tablaAnnos.empty();
    var tablaDescriptores = $("#tablaDescriptores");
    tablaDescriptores.DataTable().destroy();
    tablaDescriptores.empty();
    var tablaAutores = $("#tablaAutores");
    tablaAutores.DataTable().destroy();
    tablaAutores.empty();
    var tablaCategorias = $("#tablaCategorias");
    tablaCategorias.DataTable().destroy();
    tablaCategorias.empty();

    $("#textoBusqueda").val('');
    $("#textoBusquedaAutores").val('');
    $("#textoBusquedaEtiquetas").val('');
    $("#textoBusquedaAnos").val('');

    $("#autoresMenu").hide();
    $("#descriptoresMenu").hide();
    $("#annosMenu").hide();
    $("#categoriasMenu").hide();
    $("#divPublicaciones").hide();
    $("#divUtilidades").hide();

    $("#autoresSeleccionados").val('');
    $("#annosSeleccionados").val('');
    $("#categoriasSeleccionadas").val('');
    $("#descriptoresSeleccionados").val('');

}