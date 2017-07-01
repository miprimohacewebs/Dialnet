@extends('templates.main') @section('title') Página de inicio
@endsection
<div id="wrapper">

	<!-- Navigation -->

	<div id="page-wrapper">

		<div class="container-fluid">
			{{-- @if (Auth::check()) --}}
			<!-- Page Heading -->
			<div class="row">
				<div class="col-md-1 text-center">
					<a href="#"> <span class="fa-stack fa-2x"> <i
							class="fa fa-folder-open" aria-hidden="true"></i>
							<p class="textoInferiorIconosAwasome">Categorías</p>
					</span>
					</a>
				</div>
				<div class="col-md-1 text-center">
					<a href="#"> <span class="fa-stack fa-2x"> <i class="fa fa-users"
							aria-hidden="true"></i>
							<p class="textoInferiorIconosAwasome">Autores</p>
					</span>
					</a>
				</div>
				<div class="col-md-1 text-center">
					<a href="#"> <span class="fa-stack fa-2x"> <i class="fa fa-filter"
							aria-hidden="true"></i>
							<p class="textoInferiorIconosAwasome">A-Z</p>
					</span>
					</a>
				</div>
				<div class="col-md-6 text-center">
					<p class="parrafoResultadoDocumentosEncontrados">350 documentos encontrados</p>
				</div>
				<div class="col-md-3"></div>




				<!-- 					<h1 class="page-header"> -->
				<!-- 						Página de inicio <small>Resultado de búsqueda de documentos</small> -->
				<!-- 					</h1> -->
				<!-- 					<ol class="breadcrumb">  -->
				<!-- 					<li class="active">  -->
				<!-- 					<i class="fa fa-dashboard"></i> Dashboard  -->
				<!-- 					</li>  -->
				<!-- 					</ol>  -->

			</div>
			<!-- /.row -->

			<!-- Mensajes de error -->
			<!-- 			<div class="row"> -->
			<!-- 				<div class="col-lg-12"> -->
			<!-- 					<div class="alert alert-info alert-dismissable"> -->
			<!-- 						<button type="button" class="close" data-dismiss="alert" -->
			<!-- 							aria-hidden="true">&times;</button> -->
			<!-- 						<i class="fa fa-info-circle"></i> <strong>Información: </strong> -->
			<!-- 						Mensaje de información. -->
			<!-- 					</div> -->
			<!-- 					<div class="alert alert-success alert-dismissable"> -->
			<!-- 						<button type="button" class="close" data-dismiss="alert" -->
			<!-- 							aria-hidden="true">&times;</button> -->
			<!-- 						<i class="fa fa-thumbs-o-up"></i> <strong>Operación realizada con -->
			<!-- 							éxito.</strong> -->
			<!-- 					</div> -->
			<!-- 					<div class="alert alert-warning alert-dismissable"> -->
			<!-- 						<button type="button" class="close" data-dismiss="alert" -->
			<!-- 							aria-hidden="true">&times;</button> -->
			<!-- 						<i class="fa fa-exclamation-triangle"> </i><strong> Alerta:</strong> -->
			<!-- 						Falta algún parámetro para realizar la búsqueda. -->
			<!-- 					</div> -->
			<!-- 					<div class="alert alert-danger alert-dismissable"> -->
			<!-- 						<button type="button" class="close" data-dismiss="alert" -->
			<!-- 							aria-hidden="true">&times;</button> -->
			<!-- 						<i class="fa fa-thumbs-o-down"></i><strong> Error: </strong>No se -->
			<!-- 						puede conectar con la base de datos. -->
			<!-- 					</div> -->
			<!-- 				</div> -->
			<!-- 			</div> -->
			<!-- /.row -->

			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table id="tablaPublicaciones" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Titulo</th>
									<th>Resumen</th>
									<th>Enlaces</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<!-- /.row -->


			{{-- @endif --}}
		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<script>
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
</script>

<!-- MODALES -->
<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true"
	style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" align="center">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				</button>
			</div>
			<div id="div-forms">
				<!-- Begin # Login Form -->
				<form id="login-form">
					<div class="modal-body">
						<div id="div-login-msg">
							<div id="icon-login-msg"
								class="glyphicon glyphicon-chevron-right"></div>
							<span id="text-login-msg">Escriba su email y password</span>
						</div>
						<br> <input id="login_username" class="form-control" type="text"
							placeholder="Email" required> <br> <input id="login_password"
							class="form-control" type="password" placeholder="Password"
							required>
						<div class="checkbox">
							<label> <input type="checkbox"> Recordarme
							</label>
						</div>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-4">
								<button id="login-button" type="button"
									class="btn btn-primary btn-lg btn-block">Autenticarse</button>
							</div>
							<div class="col-md-4">
								<button class="btn btn-primary btn-lg btn-block"
									data-dismiss="modal">Cerrar</button>
							</div>
							<div class="col-md-2"></div>
						</div>

					</div>
				</form>
				<!-- End # Login Form -->
			</div>
			<!-- End # DIV Form -->
		</div>
	</div>
</div>
<!-- END # MODAL LOGIN -->