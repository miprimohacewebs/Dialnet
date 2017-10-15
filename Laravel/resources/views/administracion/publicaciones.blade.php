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

        <!-- Panel tab para insertar publicación -->
            <form role="form" name="guardarPublicacion" method="POST" action="administrador/guardarPublicacion">
                <div id="exTab2" class="container">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#1" data-toggle="tab">Datos publicación</a>
                        </li>
                        <li><a href="#2" data-toggle="tab">Selección autores/as</a>
                        </li>
                        <li><a href="#3" data-toggle="tab">Selección editores</a>
                        </li>
                        <li><a href="#4" data-toggle="tab">Subir imagen</a>
                        </li>
                    </ul>

                    <div class="tab-content ">
                        <div class="tab-pane active" id="1">
                            <div style="height: 20px; width: 100%"></div>

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
                                        <input class="form-control" id="subtitulo" name="subtitulo"
                                               value="{{old('subtitulo')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="asunto">Asunto</label>
                                        <input class="form-control" id="asunto" name="asunto" value="{{old('asunto')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="resumen">Resumen</label>
                                        <textarea class="form-control" id="resumen" rows="3"
                                                  name="resumen">{{old('resumen')}}</textarea>
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="obra">Obra</label>
                                        <input class="form-control" id="obra" name="obra" value="{{old('obra')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="descriptores">Descriptores</label>
                                        <input class="form-control" id="descriptores" name="descriptores"
                                               value="{{old('descriptores')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="genero">Género</label>
                                        <input class="form-control" id="genero" name="genero" value="{{old('genero')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="numPaginas">Núm Páginas</label>
                                        <input class="form-control" id="numPaginas" name="numPaginas"
                                               value="{{old('numPaginas')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="categoria">Categoría</label>
                                        <select class="form-control" id="categoria" name="categoria">
                                            <option value="">Seleccione...</option>
                                            @foreach($categorias as $categoriaHija)
                                                <option value="{{$categoriaHija->x_idcategoria}}" {{ $categoriaHija->x_idcategoria == old('categoria') ? "selected" : "" }}>{{$categoriaHija->tx_categoria}}</option>
                                            @endforeach
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
                                        <input class="form-control" id="edicion" name="edicion"
                                               value="{{old('edicion')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="fechaPublicacion">Fecha de publicación</label>
                                        <input class="form-control" id="fechaPublicacion" name="fechaPublicacion"
                                               value="{{old('fechaPublicacion')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="paginas">Páginas</label>
                                        <input class="form-control" id="paginas" name="paginas"
                                               value="{{old('paginas')}}">
                                        <!-- <p class="help-block">Texto de ayuda.</p> -->
                                    </div>
                                </div>
                            </div>
                            <div style="height: 20px; width: 100%"></div>


                        </div>
                        <div class="tab-pane" id="2">
                            <div style="height: 20px; width: 100%"></div>
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label>Autores/as</label>
                                        <select multiple class="form-control" id="selectAutores">
                                            @foreach($autores as $autor)
                                                <option value="{{$autor->idautor}}">{{$autor->tx_autor}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button id="btnAnadir" type="button" class="btn btn-primary btn-sm" onclick="anadirValores('selectAutores','seleccionadosAutores')">Añadir
                                    </button>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Autores/as asignados a la publicación</label>
                                        <select multiple class="form-control" id="seleccionadosAutores" name="seleccionadosAutores[]" >
                                            @if( ! empty($autoresSeleccionados))
                                                @foreach($autoresSeleccionados as $autorSeleccionado)
                                                    <option value="{{$autorSeleccionado->idAutor}}">{{$autorSeleccionado->tx_autor}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <button id="btnQuitar" type="button" class="btn btn-primary btn-sm" onclick="quitarValores('seleccionadosAutores')">Quitar
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="3">
                            <div style="height: 20px; width: 100%"></div>
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label>Editores/as</label>
                                        <select multiple class="form-control" id="selectEditores">
                                            @foreach($editores as $editor)
                                                <option value="{{$editor->x_ideditor}}">{{$editor->tx_editor}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button id="btnAnadirEditores" type="button" class="btn btn-primary btn-sm" onclick="anadirValores('selectEditores','seleccionadosEditores')">Añadir
                                    </button>

                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label>Editores/as asignados a la publicación</label>
                                        <select multiple class="form-control" id="seleccionadosEditores" name="seleccionadosEditores[]">
                                            @if( ! empty($editoresSeleccionados))
                                                @foreach($editoresSeleccionados as $editorSeleccionado)
                                                    <option value="{{$editorSeleccionado->x_ideditor}}">{{$editorSeleccionado->tx_editor}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <button id="btnQuitarEditores" type="button" class="btn btn-primary btn-sm" onclick="quitarValores('seleccionadosEditores')">Quitar
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="4">
                            <div style="height: 20px; width: 100%"></div>
                            <div class="row">
                                <div class="col-lg-2 text-center">
                                    <div class="form-group">
                                        <img src="assets/images/imagesPublicaciones/imgTemplate.jpg" alt="Imagen por defecto" title="Imagen por defecto" class="img-thumbnail">
                                        <legend style="font-size:10px"> Imagen actual </legend>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <dl class="dl-horizontal">
                                            <dt>Peso en Mb</dt>
                                            <dd>Importante, la imagen no puede tener un peso superior a 1024Kb o lo que es lo mismo 1Mb</dd>
                                            <dt>Tamaño de la imagen</dt>
                                            <dd>Para una correcta visualización la imagen debe tener un tamaño de 120px de ancho por 160px de alto.</dd>
                                         </dl>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Imagen de la publicación</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    Buscar… <input type="file" id="imgInp" name="imagenPublicacion">
                                                </span>
                                            </span>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                        <br />
                                        <img id='img-upload'/>
                                    </div>
                                </div>
                            </div>


                        </div>
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

                </div>
            </form>
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
