$.ajaxSetup({
    headers : {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {

    /*  Tabla de edición de publicaciones     */
    $("#tablaEdicionPublicaciones")
        .DataTable(
            {
                "processing" : true,
                "serverSide" : true,
                "ajax" : "/api/publicacionesAdmin",
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
                        title: 'Acciones',
                        data : 'x_idpublicacion',
                        sWidth : '10%',
                        mRender : function(data, type, full) {
                            return "<a href='/modificarPublicacion/"+data+"' id='"
                                + data
                                + "' class='detallePublicacion' title='Modificar' alt='Modificar'><i class='fa fa-pencil'></i></a>"
                                + "&nbsp;&nbsp;<a href='eliminarPublicacion/"+data+ "' id='"+data+ "' class='eliminarPublicacion' title='Eliminar'"
                                + " alt='Eliminar' onclick='return confirm(\"¿Quieres eliminar esta publicación?\");' ><i class='fa fa-trash'></i></a>";
                        }

                    } ]
            });

    /*  Tabla de edición de autores     */
    $("#tablaEdicionAutores")
        .DataTable(
            {
                "processing" : true,
                "serverSide" : true,
                "ajax" : "/api/autoresAdmin",
                "lengthChange" : false,
                "language": {
                    "processing": "Procesando autores...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen autores.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay autores disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de autores)",
                    "loadingRecords": "Cargando autores...",
                    "infoPostFix": "",
                    "emptyTable": "No existen autores disponibles.",
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    }
                },
                "columns" : [
                    {
                        title: 'Nombre autor/a',
                        data : 'tx_autor',
                        name : 'tx_autor',
                        sWidth : '30%'
                    },
                    {
                        title: 'Apellido/s autor/a',
                        data : 'tx_autorApellidos',
                        name : 'tx_autorApellidos',
                        sWidth : '70%'
                    },
                    {
                        title: 'Acciones',
                        data : 'idAutor',
                        sWidth : '10%',
                        mRender : function(data, type, full) {
                            return "<a href='/modificarAutor/"+data+"' id='"
                                + data
                                + "' class='detallePublicacion' title='Modificar'><i class='fa fa-pencil'></i></a>"
                                + "&nbsp;&nbsp;<a href='/eliminarAutor/"+data+ "' id='"+data+ "' class='eliminarPublicacion' title='Eliminar'"
                                + " onclick='return confirm(\"¿Quieres eliminar este/a editor/a?\");' ><i class='fa fa-trash'></i></a>";
                        }

                    } ]
            });


    /*  Tabla de edición de categorias     */
    $("#tablaEdicionCategorias")
        .DataTable(
            {
                "processing" : true,
                "serverSide" : true,
                "ajax" : "/api/categoriasAdmin",
                "lengthChange" : false,
                "language": {
                    "processing": "Procesando categorias...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen categorias.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay categorias disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de categorias)",
                    "loadingRecords": "Cargando categorias...",
                    "infoPostFix": "",
                    "emptyTable": "No existen categorias disponibles.",
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    }
                },
                "columns" : [
                    {
                        title: 'Categoria',
                        data : 'tx_categoria',
                        name : 'tx_categoria',
                        sWidth : '100%'
                    },
                    {
                        title: 'Acciones',
                        data : 'x_idcategoria',
                        sWidth : '10%',
                        mRender : function(data, type, full) {
                            return "<a href='/modificarCategorias/"+data+"' id='"
                                + data
                                + "' class='detallePublicacion' title='Modificar'><i class='fa fa-pencil'></i></a>"
                                + "&nbsp;&nbsp;<a href='eliminarCategoria/"+data+ "' id='"+data+ "' class='eliminarPublicacion' title='Eliminar'"
                                + " onclick='return confirm(\"¿Quieres eliminar esta categoria?\");' ><i class='fa fa-trash'></i></a>";
                        }

                    } ]
            });



    /*  Tabla de edición de editores     */
    $("#tablaEdicionEditores")
        .DataTable(
            {
                "processing" : true,
                "serverSide" : true,
                "ajax" : "/api/editores",
                "lengthChange" : false,
                "language": {
                    "processing": "Procesando editores/as...",
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                    "zeroRecords": "No existen editores/as.",
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay editores/as disponibles",
                    "infoFiltered": "(Filtrados _MAX_ del total de editores/as)",
                    "loadingRecords": "Cargando editores/as...",
                    "infoPostFix": "",
                    "emptyTable": "No existen editores/as disponibles.",
                    "paginate": {
                        "first":      "Primero",
                        "previous":   "Anterior",
                        "next":       "Siguiente",
                        "last":       "Último"
                    }
                },
                "columns" : [
                    {
                        title: 'Editores/as',
                        data : 'tx_editor',
                        name : 'tx_editor',
                        sWidth : '100%'
                    },
                    {
                        title: 'Acciones',
                        data : 'x_ideditor',
                        sWidth : '10%',
                        mRender : function(data, type, full) {
                            return "<a href='/modificarEditor/"+data+"' id='"
                                + data
                                + "' class='detallePublicacion' title='Modificar'><i class='fa fa-pencil'></i></a>"
                                + "&nbsp;&nbsp;<a href='eliminarEditor/"+data+ "' id='"+data+ "' class='eliminarPublicacion' title='Eliminar'"
                                + " onclick='return confirm(\"¿Quieres eliminar este editor/a?\");' ><i class='fa fa-trash'></i></a>";
                        }

                    } ]
            });

    $('#btnGuardar').click(function() {
        $('#seleccionadosAutores option').prop('selected', true);
        $('#seleccionadosCategorias option').prop('selected', true);
        $('#seleccionadosEtiquetas option').prop('selected', true);
        $('#guardarPublicacion').submit();
    });
});
$( "#tags" ).autocomplete({
    source: function (request, response) {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '/api/obtenerDescriptores/' + request.term,
            success: function (data) {
                response( data );
            }
        });
    }
});
function anadirValores(selectSeleccion, selectAnadir){

    for(var i =0; i < $("#"+selectSeleccion)[0].selectedOptions.length; i++){
        var texto = $("#"+selectSeleccion)[0].selectedOptions[i].text;
        var valor = $("#"+selectSeleccion)[0].selectedOptions[i].value;
        var option = new Option(texto, parseInt(valor));
        $("#"+selectAnadir).append(option);
    }

    var found = [];
    $("#"+selectAnadir+" option").each(function() {
        if($.inArray(this.value, found) !== -1) $(this).remove();
        found.push(this.value);
    });
}

function quitarValores (select){
    $('#'+select+' :selected').each(function(i, selected){
        $('#'+select+' option[value="'+selected.value+'"]').remove();
    });

}

function anadirValoresAutocomplete(campoAnadir, selectAnadir){


    var texto = $("#"+campoAnadir)[0].value;
    var valor = $("#"+campoAnadir)[0].value;
    var option = new Option(texto, valor);
    $("#"+selectAnadir).append(option);

    var found = [];
    $("#"+selectAnadir+" option").each(function() {
        if($.inArray(this.value, found) !== -1) $(this).remove();
        found.push(this.value);
    });

    $("#"+campoAnadir)[0].value = "";
}

$(document).on('change', '.btn-file :file', function() {
    var input = $(this),
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
});

$('.btn-file :file').on('fileselect', function(event, label) {

    var input = $(this).parents('.input-group').find(':text'),
        log = label;

    if( input.length ) {
        input.val(log);
    } else {
        if( log ) alert(log);
    }

});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img-upload').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});
