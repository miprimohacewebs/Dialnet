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
                            return "<a href='modificarPublicacion' id='"
                                + data
                                + "' class='detallePublicacion'  data-toggle='modal' data-target='#modificar' title='Modificar' alt='Modificar'><i class='fa fa-pencil'></i></a>"
                                + "&nbsp;&nbsp;<a href='eliminarPublicacion' id='"+data+ "' class='descargarPublicacion'  data-toggle='modal' data-target='#eliminarPublicacion' title='Eliminar'"
                                + " alt='Eliminar'><i class='fa fa-trash'></i></a>";
                        }

                    } ]
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


