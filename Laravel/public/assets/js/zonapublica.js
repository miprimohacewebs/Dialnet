$(function() {
    $('#tablaPublicaciones').DataTable({
        processing: true,
        serverSide: true,
        ajax:  '{!! url("data") !!}',
        columns: [
            { data: 'tx_titulo', name: 'tx_titulo' },
            { data: 'tx_resumen', name: 'tx_resumen' },
            { data: 'x_idpublicacion', name: 'x_idpublicacion' }
        ]
    });
});