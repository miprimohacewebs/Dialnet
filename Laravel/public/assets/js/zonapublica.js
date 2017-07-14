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
			data : 'fh_fechapublicacion',
			name : 'fh_fechapublicacion'
		} ]
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
	            $(nTd).html("<a href='idCategoria:"+oData.x_idcategoria+"'>"+oData.tx_categoria+"</a>");
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
	            $(nTd).html("<a href='idAutor:"+oData.x_idautor+"'>"+oData.tx_autor+"</a>");
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
	            $(nTd).html("<a href='txTitulo:"+oData.letras+"'>"+oData.letras+"</a>");
			}
		} ]
	});
	
	$("#tablaCategorias").DataTable({
		"serverSide" : false,
		"lengthChange": false,
		"info": false,
		"searching": false,
		"pageLength": 1,
		"pagingType": "simple",
		"ajax" : "/api/categorias",
		"columns" : [ {
			data : 'tx_categoria',
			"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	            $(nTd).html("<a href='idCategoria:"+oData.x_idcategoria+"'>"+oData.tx_categoria+"</a>");
			}
		} ]
	});
	
	$("#tablaAutores").DataTable({
		"serverSide" : false,
		"lengthChange": false,
		"info": false,
		"searching": false,
		"pageLength": 1,
		"pagingType": "simple",
		"ajax" : "/api/autores",
		"columns" : [ {
			data : 'tx_autor',
			"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	            $(nTd).html("<a href='idAutor:"+oData.x_idautor+"'>"+oData.tx_autor+"</a>");
			}
		} ]
	});
	
	$('#categorias').click(function(){
	    $('#categoriasMenu').show();
	    $('#autoresMenu').hide();
	});

	$('#autores').click(function(){
	    $('#categoriasMenu').hide();
	    $('#autoresMenu').show();
	});
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





