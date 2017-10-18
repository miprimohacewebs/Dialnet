@extends('layouts.app')
@section('title')
    Administración de editores/as
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
            <!-- Título sección -->
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-10">
                    <h3>Administrar editores/as</h3>
                    <div style="height: 40px; width: 100%"></div>
                </div>
            </div>
            <form role="form" name="guardarAutor" method="POST" action="administrador/guardarEditor">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="titulo">Nombre y apellidos de editores/as</label>
                            <input class="form-control" id="editor" name="editor" value="{{old('editor')}}">
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
                <!-- Tabla edición/eliminar editores-->
                <div style="height: 50px; width: 100%"></div>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <table id="tablaEdicionEditores" class="table table-hover table-condensed">
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

        </div>
        </form>


    </div>
    </div>

@endsection