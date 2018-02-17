$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/** Constantes */
var RUTA_IMAGENES = 'assets/images/imagesPublicaciones/';



/** Carga de tabla publicaciones */
$(function () {
        var tablaPublicaciones =  $("#tablaPublicaciones")
        .DataTable(
            {
                // "dom": '<"top"i>rt<"bottom"flp><"clear">',
                "processing": true,
                "serverSide": true,
                "ajax": "/api/publicaciones",
                "lengthChange": true,
                "pageLength": 20,
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
                        $(nTd).html("<strong style ='color: #ba0600; font-family: 'Josefin Sans', sans-serif;'> <i class='fa fa-angle-right'></i> " + oData.tx_titulo + "</strong>, <strong style ='color: #ba0600; font-family: 'Josefin Sans', sans-serif;'> ISBN/ISSN: </strong>" + oData.tx_isbn  + ", <strong style ='color: #ba0600; font-family: 'Josefin Sans', sans-serif;'> AÑO: </strong>" + oData.nu_anno + ", <strong style ='color: #ba0600; font-family: 'Josefin Sans', sans-serif;'> PUBLICACIÓN: </strong>" + oData.tx_publicacion + " <a href='detallePublicacion id='' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>");

                    },



                }],

                /*
                "columns": [
                    {
                        title: 'Título',
                        data: 'tx_titulo',
                        name: 'tx_titulo',
                        sWidth: '50%'
                    },
                    {
                        title: 'ISBN/ISSN',
                        data: 'tx_isbn',
                        name: 'tx_isbn',
                        sWidth: '10%'
                    },
                    {
                        title: 'Año',
                        data: 'nu_anno',
                        name: 'nu_anno',
                        sWidth: '5%'
                    },
                    {
                        title: 'Publicación',
                        data: 'tx_publicacion',
                        name: 'tx_publicacion',
                        sWidth: '35%'
                    },
                    {
                        title: 'Detalle',
                        data: 'x_idpublicacion',
                        sWidth: '20%',
                        mRender: function (data, type, full) {
                            return "<a href='detallePublicacion' id='"
                                + data
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>";
                        }

                    }]
                    */
            });

         jQuery.fn.DataTable.ext.type.search.string = function ( data ) {
            return ! data ?
                '' :
                typeof data === 'string' ?
                    data
                        .replace( /έ/g, 'ε' )
                        .replace( /[ύϋΰ]/g, 'υ' )
                        .replace( /ό/g, 'ο' )
                        .replace( /ώ/g, 'ω' )
                        .replace( /ά/g, 'α' )
                        .replace( /[ίϊΐ]/g, 'ι' )
                        .replace( /ή/g, 'η' )
                        .replace( /\n/g, ' ' )
                        .replace( /á/g, 'a' )
                        .replace( /é/g, 'e' )
                        .replace( /í/g, 'i' )
                        .replace( /ó/g, 'o' )
                        .replace( /ú/g, 'u' )
                        .replace( /ê/g, 'e' )
                        .replace( /î/g, 'i' )
                        .replace( /ô/g, 'o' )
                        .replace( /è/g, 'e' )
                        .replace( /ï/g, 'i' )
                        .replace( /ü/g, 'u' )
                        .replace( /ã/g, 'a' )
                        .replace( /õ/g, 'o' )
                        .replace( /ç/g, 'c' )
                        .replace( /ì/g, 'i' ) :
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
                        // ISBN
                        if (data.publicacion[0].tx_isbn) {
                            html += "<div class='row'>";
                            html += "<div class='col-md-3'><strong>ISBN/ISSN:</strong></div>";
                            html += "<div class='col-md-9'>";
                            html += data.publicacion[0].tx_isbn;
                            html += "</div>";
                            html += "</div>";
                        }
                        // Año
                        if (data.publicacion[0].nu_ano) {
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
                            html += "<div class='col-md-3'><strong>Núm. páginas:</strong></div>";
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
                        // Publicación
                        if (data.publicacion[0].tx_publicacion) {
                            html += "<div class='row'>";
                            html += "<div class='col-md-3'><strong>Publicación:</strong></div>";
                            html += "<div class='col-md-9'>";
                            html += data.publicacion[0].tx_publicacion;
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
                        // Descriptores
                        if (data.publicacion[0].tx_descriptores) {
                            html += "<div class='row'>";
                            html += "<div class='col-md-3'><strong>Descriptores:</strong></div>";
                            html += "<div class='col-md-9'>";
                            html += data.publicacion[0].tx_descriptores;
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
                        // DOI
                        if(data.publicacion[0].tx_doi){
                         html += "<div class='row'>";
                         html += "<div class='col-md-3'><strong>DOI:</strong></div>";
                         html += "<div class='col-md-9'>";
                         html += data.publicacion[0].tx_doi;
                         html += "</div>";
                         html += "</div>";
                         }
                          // Genero
                         if(data.publicacion[0].tx_enlacedoi){
                         html += "<div class='row'>";
                         html += "<div class='col-md-3'><strong>Enlace DOI:</strong></div>";
                         html += "<div class='col-md-9'>";
                         html += data.publicacion[0].tx_enlacedoi;
                         html += "</div>";
                         html += "</div>";
                         }

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
                        // Fecha de publicación
                        if (data.publicacion[0].fh_fechapublicacion) {
                            html += "<div class='row'>";
                            html += "<div class='col-md-3'><strong>Fecha de publicación:</strong></div>";
                            html += "<div class='col-md-9'>";
                            html += data.publicacion[0].fh_fechapublicacion;
                            html += "</div>";
                            html += "</div>";
                        }
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
                        // Autores
                        if (data.publicacion[0].autores) {
                            html += "<div class='row'>";
                            html += "<div class='col-md-3'><strong>Autores/as:</strong></div>";
                            html += "<div class='col-md-9'>";
                            html += data.publicacion[0].autores;
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
        $("#tablaCategorias").DataTable({
            "serverSide": false,
            "lengthChange": false,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "pagingType": "simple",
            "ajax": "/api/categorias",
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
                    "first": "Primero",
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "last": "Último"
                }
            },
            "columns": [{
                data: 'nombre',
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<a href='#' > <i class='fa fa-check-circle'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }
            }]
        });



        $("#tablaAutores").DataTable({
            "serverSide": false,
            "lengthChange": false,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "pagingType": "simple",
            "ajax": "/api/autores",
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
                    "first": "Primero",
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "last": "Último"
                }
            },
            "columns": [{
                data: 'nombre',
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<a href='#'><i class='fa fa-check-circle'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }
            }]
        });

        $("#tablaDescriptores").DataTable({
            "serverSide": false,
            "lengthChange": false,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "pagingType": "simple",
            "ajax": "/api/descriptores",
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
                    "first": "Primero",
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "last": "Último"
                }
            },
            "columns": [{
                data: 'nombre',
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<a href='#'><i class='fa fa-check-circle'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }
            }]
        });

        $("#tablaAnnos").DataTable({
            "serverSide": false,
            "lengthChange": false,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "pagingType": "simple",
            "ajax": "/api/annos",
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
                    "first": "Primero",
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "last": "Último"
                }
            },
            "columns": [{
                data: 'nombre',
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<a href='#'><i class='fa fa-check-circle'></i> " + oData.nombre + "&nbsp;&nbsp;&nbsp;&nbsp;(" + oData.numPublicaciones + ")</a>");
                }
            }]
        });
    }

    );

/**
 *
 * Función que actualiza la tabla de publicaciones filtrando por el valor seleccionado.
 * Tipo: indica el tipo de filtro a realizar opciones posibles:
 *        - cat: filtra por categorias.
 *        - tit: filtra por primera letra del título.
 *        - aut: filtra por el autor.
 */
function actualizarListado(tipo, valor) {

    var tablaPublicaciones = $("#tablaPublicaciones");
    tablaPublicaciones.DataTable().destroy();
    tablaPublicaciones.empty();


    tablaPublicaciones
        .DataTable(
            {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/api/publicacionesFiltro",
                    "type": "GET",
                    "data": {
                        "valor": valor,
                        "tipo": tipo
                    }
                },
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
                "columns": [
                    {
                        title: 'Título',
                        data: 'tx_titulo',
                        name: 'tx_titulo',
                        sWidth: '50%'
                    },
                    {
                        title: 'ISBN/ISSN',
                        data: 'tx_isbn',
                        name: 'tx_isbn',
                        sWidth: '10%'
                    },
                    {
                        title: 'Año',
                        data: 'nu_anno',
                        name: 'nu_anno',
                        sWidth: '5%'
                    },
                    {
                        title: 'Publicación',
                        data: 'tx_publicacion',
                        name: 'tx_publicacion',
                        sWidth: '35%'
                    },
                    {
                        title: 'Ver detalle',
                        data: 'x_idpublicacion',
                        sWidth: '10%',
                        mRender: function (data, type, full) {
                            return "<a href='detallePublicacion' id='"
                                + data
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>";
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

    tablaPublicaciones
        .DataTable(
            {
                "processing": true,
                "serverSide": true,
                "ajax": "/api/publicaciones",
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
                "columns": [
                    {
                        title: 'Título',
                        data: 'tx_titulo',
                        name: 'tx_titulo',
                        sWidth: '50%'
                    },
                    {
                        title: 'ISBN/ISSN',
                        data: 'tx_isbn',
                        name: 'tx_isbn',
                        sWidth: '10%'
                    },
                    {
                        title: 'Año',
                        data: 'nu_anno',
                        name: 'nu_anno',
                        sWidth: '5%'
                    },
                    {
                        title: 'Publicación',
                        data: 'tx_publicacion',
                        name: 'tx_publicacion',
                        sWidth: '35%'
                    },
                    {
                        title: 'Ver detalle',
                        data: 'x_idpublicacion',
                        sWidth: '10%',
                        mRender: function (data, type, full) {
                            return "<a href='detallePublicacion' id='"
                                + data
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#verDetalle' title='Ver detalle' alt='Ver detalle'><i class='fa fa-book'></i></a>";
                        }

                    }]
            });

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
}