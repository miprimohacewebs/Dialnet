@extends('layouts.app')
@section('title')
    Página de Administracion
@endsection
@section('content')
    <div style="height: 50px; width: 100%"></div>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-civermov">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-folder-open fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><h4>Categorías</h4>{{$categorias}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('categoriasadmin')}}">
                            <div class="panel-footer">
                                <span class="pull-left">Administrar categorías</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-civermov002">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><h4>Autores/as</h4>{{$autores}}</div>
                               </div>
                            </div>
                        </div>
                        <a href="{{url('autoresadmin')}}">
                            <div class="panel-footer">
                                <span class="pull-left">Administrar autores/as</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-civermov003">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><h4>XXX</h4> 124</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Administrar XXX</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-civermov004">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><h4>Publicaciones</h4> {{$publicaciones}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('publicacionesadmin')}}">
                            <div class="panel-footer">
                                <span class="pull-left">Administrar publicaciones</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div style="height: 50px; width: 100%"></div>
            @if(session()->has('alert-success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session()->get('alert-success') }}
                </div>
            @endif
            @if(session()->has('alert-error'))
                <div class="alert alert-error alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session()->get('alert-error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <table id="tablaEdicionPublicaciones" class="table table-hover table-condensed">
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
