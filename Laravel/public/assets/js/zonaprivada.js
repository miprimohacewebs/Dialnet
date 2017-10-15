$.ajaxSetup({
	headers : {
		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	}
});

$(function() {
    $("#tablaEdicionPublicaciones")
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
                        title: 'Acciones',
                        data : 'x_idpublicacion',
                        sWidth : '10%',
                        mRender : function(data, type, full) {
                            return "<a href='modificarPublicacion/"+data+"' id='"
                                + data
                                + "' class='detallePublicacion' title='Modificar' alt='Modificar'><i class='fa fa-pencil'></i></a>"
                                + "&nbsp;&nbsp;<a href='eliminarPublicacion/"+data+ "' id='"+data+ "' class='eliminarPublicacion' title='Eliminar'"
                                + " alt='Eliminar' onclick='return confirm(\"¿Quieres eliminar esta publicación?\");' ><i class='fa fa-trash'></i></a>";
                        }

                    } ]
            });


    $('#btnGuardar').click(function() {
        $('#seleccionadosAutores option').prop('selected', true);
        $('#seleccionadosEditores option').prop('selected', true);
        $('#guardarPublicacion').submit();
    });
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
        if($.inArray(this.value, found) != -1) $(this).remove();
        found.push(this.value);
    });
}

function quitarValores (select){
    $('#'+select+' :selected').each(function(i, selected){
        $('#'+select+' option[value="'+selected.value+'"]').remove();
    });

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
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});
