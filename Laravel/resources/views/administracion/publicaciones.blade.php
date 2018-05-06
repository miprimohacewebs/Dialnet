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
                            class="btn btn-primary btn-sm btn-block"
                            onclick="window.location='{{url('administracion')}}'">Volver
                    </button>
                </div>
            </div>
            <div style="height: 50px; width: 100%"></div>
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
            @if(session()->has('alert-error'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session()->get('alert-error') }}
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
                    <h3 style="color: #ba0600;"><i class="fa fa-chevron-right" aria-hidden="true"></i> Administrar
                        publicaciones</h3>
                    <div style="height: 40px; width: 100%"></div>
                </div>
            </div>
            <!-- Panel tab para insertar publicación -->
            @if(isset($publicacion) || old('idPublicacion')!=null)
                <form role="form" name="guardarPublicacion" method="POST"
                      action="/administrador/modificarPublicacion/{{old('idPublicacion',isset($publicacion) ? $publicacion['idPublicacion'] : null)}}"
                      enctype="multipart/form-data">
                    <input type="hidden" name="idGrupoAutores" id="idGrupoAutores"
                           value="{{ old('idGrupoAutores',isset($publicacion) ? $publicacion['idAutor'] : null)}}"/>
                    <input type="hidden" name="idGrupoEditores" id="idGrupoEditores"
                           value="{{ old('idGrupoEditores',isset($publicacion) ? $publicacion['idEditor'] : null)}}"/>
                    <input type="hidden" name="idGrupoCategorias" id="idGrupoCategorias"
                           value="{{ old('idGrupoCategorias',isset($publicacion) ? $publicacion['idCategoria'] : null)}}"/>
                    <input type="hidden" name="idGrupoEtiquetas" id="idGrupoEtiquetas"
                           value="{{ old('idGrupoEtiquetas',isset($publicacion) ? $publicacion['idDescriptor'] : null)}}"/>
                    <input type="hidden" name="idPublicacion" id="idPublicacion"
                           value="{{ old('idPublicacion',isset($publicacion) ? $publicacion['idPublicacion'] : null)}}"/>
                    @else
                        <form role="form" name="guardarPublicacion" method="POST"
                              action="/administrador/guardarPublicacion" enctype="multipart/form-data">
                            @endif

                            <div id="exTab2" class="container">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#1" data-toggle="tab">Datos publicación</a>
                                    </li>
                                    <li><a href="#2" data-toggle="tab">Selección autores/as</a>
                                    </li>
                                    <li><a href="#3" data-toggle="tab">Selección categorías</a>
                                    </li>
                                    <li><a href="#4" data-toggle="tab">Selección etiquetas</a>
                                    </li>
                                    <li><a href="#5" data-toggle="tab">Subir imagen</a>
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
                                                    <label for="titulo" title="Campo Obligatorio">Título  <span style="color:red">*</span></label>
                                                    <input class="form-control" id="titulo" name="titulo"
                                                           value="{{ old('titulo',isset($publicacion) ? $publicacion['titulo'] : null)}}">
                                                    <p class="help-block">Introduzca el título de la publicación</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="resumen">Resumen</label>
                                                    <textarea class="form-control" id="resumen" rows="3"
                                                              name="resumen">{{old('resumen',isset($publicacion) ? $publicacion['resumen'] : null)}}</textarea>
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="publicacion">Publicación</label>
                                                    <input class="form-control" id="publicacion" name="publicacion"
                                                           value="{{ old('publicacion',isset($publicacion) ? $publicacion['publicacion'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                {{--<div class="form-group">--}}
                                                {{--<label for="descriptores">Descriptores</label>--}}
                                                {{--<input class="form-control" id="descriptores" name="descriptores"--}}
                                                {{--value="{{ old('descriptores',isset($publicacion) ? $publicacion['descriptores'] : null)}}">--}}
                                            <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                {{--</div>--}}
                                                <div class="form-group">
                                                    <label for="numPaginas">Núm. Páginas</label>
                                                    <input class="form-control" id="numPaginas" name="numPaginas"
                                                           value="{{ old('numPaginas',isset($publicacion) ? $publicacion['numPaginas'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="doi">DOI</label>
                                                    <input class="form-control" id="doi" name="doi"
                                                           value="{{ old('doi',isset($publicacion) ? $publicacion['doi'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="enlacedoi">Enlace al texto</label>
                                                    <input class="form-control" id="enlacedoi" name="enlacedoi"
                                                           value="{{ old('enlacedoi',isset($publicacion) ? $publicacion['enlacedoi'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                {{--<div class="form-group">
                                                    <label for="categoria">Categoría</label>
                                                    <select class="form-control" id="categoria" name="categoria">
                                                        <option value="">Seleccione...</option>
                                                        @foreach($categorias as $categoriaHija)
                                                            <option value="{{$categoriaHija->x_idcategoria}}" {{ $categoriaHija->x_idcategoria == old('categoria', isset($publicacion) ? $publicacion['categoria'] : null) ? "selected" : "" }}>{{$categoriaHija->tx_categoria}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>--}}
                                                <div class="form-group">
                                                    <label for="isbn">ISBN/ISSN</label>
                                                    <input class="form-control" id="isbn" name="isbn"
                                                           value="{{ old('isbn',isset($publicacion) ? $publicacion['isbn'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="anno">Año</label>
                                                    <input class="form-control" id="anno" name="anno"
                                                           value="{{ old('anno',isset($publicacion) ? $publicacion['anno'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="pais">Lugar de edición</label>
                                                    <input class="form-control" id="pais" name="pais"
                                                           value="{{ old('pais',isset($publicacion) ? $publicacion['pais'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="idioma">Idioma</label>
                                                    <input class="form-control" id="idioma" name="idioma"
                                                           value="{{ old('idioma',isset($publicacion) ? $publicacion['idioma'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="editorial">Editor/Revista</label>
                                                    <input class="form-control" id="editorial" name="editorial"
                                                           value="{{ old('editorial',isset($publicacion) ? $publicacion['editorial'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>

                                                <div class="form-group">
                                                    <label for="asunto">Edición/Volumen</label>
                                                    <input class="form-control" id="asunto" name="asunto"
                                                           value="{{ old('asunto',isset($asunto) ? $publicacion['asunto'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="fechaPublicacion">Fecha de publicación</label>
                                                    <input class="form-control" id="fechaPublicacion"
                                                           name="fechaPublicacion"
                                                           value="{{ old('fechaPublicacion',isset($publicacion) ? $publicacion['fechaPublicacion'] : null)}}">
                                                    <!-- <p class="help-block">Texto de ayuda.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="paginas">Páginas</label>
                                                    <input class="form-control" id="paginas" name="paginas"
                                                           value="{{ old('paginas',isset($publicacion) ? $publicacion['paginas'] : null)}}">
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
                                                            <option value="{{$autor->idautor}}">{{$autor->tx_autorapellidos}}
                                                                , {{$autor->tx_autor}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button id="btnAnadir" type="button" class="btn btn-primary btn-sm"
                                                        onclick="anadirValores('selectAutores','seleccionadosAutores')">
                                                    Añadir
                                                </button>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Autores/as asignados a la publicación</label>
                                                    <select multiple class="form-control" id="seleccionadosAutores"
                                                            name="seleccionadosAutores[]">
                                                        @if( !empty($autoresSeleccionados))
                                                            @foreach($autoresSeleccionados as $autorSeleccionado)
                                                                <option value="{{$autorSeleccionado->idAutor}}">{{$autorSeleccionado->tx_autorapellidos}}
                                                                    , {{$autorSeleccionado->tx_autor}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                                <button id="btnQuitar" type="button" class="btn btn-primary btn-sm"
                                                        onclick="quitarValores('seleccionadosAutores')">Quitar
                                                </button>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane" id="3">
                                        <div style="height: 20px; width: 100%"></div>
                                        <div class="row">
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label>Categorías</label>
                                                    <select multiple class="form-control" id="selectCategorias">
                                                        @foreach($categorias as $categoria)
                                                            <option value="{{$categoria->x_idcategoria}}">{{$categoria->tx_categoria}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button id="btnAnadirCategorias" type="button"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="anadirValores('selectCategorias','seleccionadosCategorias')">
                                                    Añadir
                                                </button>

                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label>Categorías asignadas a la publicación</label>
                                                    <select multiple class="form-control" id="seleccionadosCategorias"
                                                            name="seleccionadosCategorias[]">
                                                        @if( ! empty($categoriasSeleccionadas))
                                                            @foreach($categoriasSeleccionadas as $categoriaSeleccionada)
                                                                <option value="{{$categoriaSeleccionada->x_idcategoria}}">{{$categoriaSeleccionada->tx_categoria}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <button id="btnQuitarCategorias" type="button"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="quitarValores('seleccionadosCategorias')">Quitar
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="4">
                                        <div style="height: 20px; width: 100%"></div>
                                        <div class="row">
                                            <div class="col-lg-3">

                                                <div class="form-group">
                                                    <label for="tags">Etiqueta: </label>
                                                    <input id="tags">
                                                </div>

                                            </div>
                                            <div class="col-lg-1">

                                                <div class="form-group">
                                                    <button id="btnAnadirEtiqueta" type="button"
                                                            class="btn btn-primary btn-sm"
                                                            onclick="anadirValoresAutocomplete('tags','seleccionadosEtiquetas')">
                                                        Añadir
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label>Etiquetas asignadas a la publicación</label>
                                                    <select multiple class="form-control" id="seleccionadosEtiquetas"
                                                            name="seleccionadosEtiquetas[]">
                                                        @if( ! empty($etiquetasSeleccionadas))
                                                            @foreach($etiquetasSeleccionadas as $etiquetaSeleccionada)
                                                                <option value="{{$etiquetaSeleccionada['tx_descriptor']}}">{{$etiquetaSeleccionada['tx_descriptor']}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <button id="btnQuitarEtiquetas" type="button"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="quitarValores('seleccionadosEtiquetas')">Quitar
                                                </button>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane" id="5">
                                        <div style="height: 20px; width: 100%"></div>
                                        <div class="row">
                                            <div class="col-lg-2 text-center">
                                                <div class="form-group">
                                                    <img src="{{old('imagenPublicacionAnt', isset($publicacion)?$publicacion['imagenPublicacionAnt']:'assets/images/imagesPublicaciones/imgTemplate.jpg')}}"
                                                         onerror="this.src='/assets/images/imagesPublicaciones/imgTemplate.jpg'"
                                                         alt="Imagen por defecto" title="Imagen por defecto"
                                                         class="img-thumbnail">
                                                    <legend style="font-size:10px"> Imagen actual</legend>
                                                    <input type="hidden" name="imagenPublicacionAnt"
                                                           id="imagenPublicacionAnt"
                                                           value="{{old('imagenPublicacionAnt', isset($publicacion)?$publicacion['imagenPublicacionAnt']:null)}}"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <dl class="dl-horizontal">
                                                        <dt>Peso en Mb</dt>
                                                        <dd>Importante, la imagen no puede tener un peso superior a
                                                            1024Kb o lo que es lo mismo 1Mb
                                                        </dd>
                                                        <dt>Tamaño de la imagen</dt>
                                                        <dd>Para una correcta visualización la imagen debe tener un
                                                            tamaño de 120px de ancho por 160px de alto.
                                                        </dd>
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
                                                    <br/>
                                                    <img id='img-upload'/>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div style="height: 20px; width: 100%"></div>
                                <div class="row">
                                    <div class="col-md-9">
                                    </div>
                                    <div class="col-md-3">
                                        <button id="btnReset" type="reset"
                                                class="btn btn-primary btn-sm"
                                                @if(isset($publicacion) || old('idPublicacion')!=null)disabled="disabled"@endif>
                                            Limpiar
                                        </button>
                                        <button id="btnCancelar" type="button"
                                                class="btn btn-primary btn-sm"
                                                @if(!isset($publicacion) && old('idPublicacion')==null)disabled="disabled"
                                                @endif onclick="window.location='{{url('publicacionesadmin')}}'">
                                            Cancelar
                                        </button>
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
                        <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <table id="tablaEdicionPublicaciones" class="table table-hover table-condensed">
                                </table>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div style="height: 50px; width: 100%"></div>
                        <!-- Botón volver -->
                        <div class="row">
                            <div class="col-md-11">
                            </div>
                            <div class="col-md-1">
                                <button id="btnVolver2" type="button"
                                        class="btn btn-primary btn-sm btn-block"
                                        onclick="window.location='{{url('administracion')}}'">Volver
                                </button>
                            </div>
                        </div>
        </div>
    </div>

@endsection
