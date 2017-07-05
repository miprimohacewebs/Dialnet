$(function(){
	$("#tablaPublicaciones").DataTable({
		 processing: true,
	     serverSide: true,
	     ajax: '/publicaciones/consiguePublicaciones',
	        
	});
});	