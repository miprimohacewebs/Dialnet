@extends('layouts.app')
@section('title')
    Administración de categorías
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Botón volver -->
            <div class="row">
                <div class="col-md-11">
                </div>
                <div class="col-md-1">
                    <button id="btnVolver1" type="button"
                            class="btn btn-primary btn-sm btn-block" onclick="history.back()">Volver
                    </button>
                </div>
            </div>
            <!-- Mensajes de error -->
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session()->has('alert-success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session()->get('alert-success') }}
                </div>
            @endif
            <!-- Título sección -->
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-10">
                    <h3>Administrar categorias</h3>
                    <div style="height: 40px; width: 100%"></div>
                </div>
            </div>

            <!-- Panel tab para insertar publicación -->
            <form role="form" name="guardarCategoria" method="POST" action="administrador/guardarCategoria">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="titulo">Categoria *</label>
                            <input class="form-control" id="categoria" name="categoria" value="{{old('categoria')}}" required>
                            <!-- <p class="help-block">Texto de ayuda.</p> -->
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>

                <div style="height: 20px; width: 100%"></div>
                <div class="row">
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-1">
                        <button id="btnReset" type="reset"
                                class="btn btn-primary btn-sm">Limpiar
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button id="btnGuardar" type="submit"
                                class="btn btn-primary btn-sm">Guardar
                        </button>
                    </div>
                </div>
                <!-- Tabla edición/eliminar autores-->
                <div style="height: 50px; width: 100%"></div>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <table id="tablaEdicionCategorias" class="table table-hover table-condensed">
                        </table>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>

                <!-- Botón volver -->
                <div style="height: 50px; width: 100%"></div>
                <div class="row">
                    <div class="col-md-11">
                    </div>
                    <div class="col-md-1">
                        <button id="btnVolver2" type="button"
                                class="btn btn-primary btn-sm btn-block" onclick="history.back()">Volver
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
