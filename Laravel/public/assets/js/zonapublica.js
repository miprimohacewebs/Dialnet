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
			data : 'fh_fechapublicaciones',
			name : 'fh_fechapublicaciones'
		} ]
	});
});