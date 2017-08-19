@extends('layouts.app')
@section('title')
    Administración de publicaciones
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

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Panel tab para insertar publicación -->
            <div id="exTab2" class="container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a  href="#1" data-toggle="tab">Datos publicación</a>
                    </li>
                    <li><a href="#2" data-toggle="tab">Selección autores/as</a>
                    </li>
                    <li><a href="#3" data-toggle="tab">Selección ...</a>
                    </li>
                </ul>

                <div class="tab-content ">
                    <div class="tab-pane active" id="1">
                        <div style="height: 20px; width: 100%"></div>
                        <form role="form" name="guardarPublicacion" action="administrador/guardarPublicacion">
                            <!-- <h3>Standard tab panel created on bootstrap using nav-tabs</h3> -->
                            <div class="row">
                                <div class="col-lg-6">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="titulo">Título</label>
                                        <input class="form-control" id="titulo" name="titulo" value="{{old('titulo')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitulo">Subtítulo</label>
                                        <input class="form-control" id="subtitulo" name="subtitulo" value="{{old('subtitulo')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="asunto">Asunto</label>
                                        <input class="form-control" id="asunto" name="asunto" value="{{old('asunto')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="resumen">Resumen</label>
                                        <textarea class="form-control" id="resumen" rows="3" name="resumen" content="{{old('resumen')}}"></textarea>
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="obra">Obra</label>
                                        <input class="form-control" id="obra" name="obra" value="{{old('obra')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="descriptores">Descriptores</label>
                                        <input class="form-control" id="descriptores" name="descriptores" value="{{old('descriptores')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="genero">Género</label>
                                        <input class="form-control" id="genero" name="genero" value="{{old('genero')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="numPaginas">Núm Páginas</label>
                                        <input class="form-control" id="numPaginas" name="numPaginas" value="{{old('numPaginas')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="categoria">Categoría</label>
                                        <select class="form-control" id="categoria" name="categoria" value="{{old('categoria')}}">
                                            <option>Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="isbn">ISBN</label>
                                        <input class="form-control" id="isbn" name="isbn" value="{{old('isbn')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="anno">Año</label>
                                        <input class="form-control" id="anno" name="anno" value="{{old('anno')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="pais">País</label>
                                        <input class="form-control" id="pais" name="pais" value="{{old('pais')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="idioma">Idioma</label>
                                        <input class="form-control" id="idioma" name="idioma" value="{{old('idioma')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="edicion">Edición</label>
                                        <input class="form-control" id="edicion" name="edicion" value="{{old('edicion')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="fechaPublicacion">Fecha de publicación</label>
                                        <input class="form-control" id="fechaPublicacion" name="fechaPublicacion" value="{{old('fechaPublicacion')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="paginas">Páginas</label>
                                        <input class="form-control" id="paginas" name="paginas" value="{{old('paginas')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                </div>
                            </div>
                            <div style="height: 20px; width: 100%"></div>
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-1">
                                    <button id="btnReset" type="reset"
                                            class="btn btn-primary btn-sm btn-block" >Limpiar
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <button id="btnGuardar" type="submit"
                                            class="btn btn-primary btn-sm btn-block" >Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="2">
                        <div style="height: 20px; width: 100%"></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <form role="form">
                                    <div class="form-group">
                                        <label>Autores/as</label>
                                        <select multiple class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <button id="btnAnadir" type="button" class="btn btn-primary btn-sm" >Añadir
                                    </button>
                                </form>
                            </div>
                            <div class="col-lg-6">
                                <form role="form">
                                    <div class="form-group">
                                        <label>Autores/as asignados a la publicación</label>
                                        <select multiple class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <button id="btnQuitar" type="button" class="btn btn-primary btn-sm" >Quitar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="3">
                        <div style="height: 20px; width: 100%"></div>
                        <p>Por ver</p>
                    </div>
                </div>
            </div>
            <!-- Tabla edición/eliminar publicaciones-->
            <div style="height: 50px; width: 100%"></div>
            <div class="row">
                <div class="col-md-12">
                    <table id="tablaEdicionPublicaciones" class="table table-hover table-condensed">
                    </table>
                </div>
            </div>
            <div style="height: 50px; width: 100%"></div>
            <!-- Botón volver -->
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
    </div>

@endsection
