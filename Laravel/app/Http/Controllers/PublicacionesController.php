<?php

namespace App\Http\Controllers;
use App\Publicaciones;
use App\Categorias;
use App\Autores;
use Datatables;
use Illuminate\Http\Request;
use App\Http\Requests;

class PublicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('publicaciones.index');
    }
    
    /**
     * Muestra los campos de la tablaPublicaciones
     * @return publicaciones para rellenar el datatable
     */
    public function getTablaPublicaciones()
    {
        $publicaciones = Publicaciones::all();
        return Datatables::of($publicaciones)->make(true);
        
    }

    /**
     * Muestra los campos de la tablaPublicaciones
     * @param int $valor
     * @param String $tipo tipo de valor, 'cat' categoria, 'aut' autor, 'tit' titulo. 
     * @return publicaciones para rellenar el datatable.
     */
    public function getTablaPublicacionesFiltro(Request $request)
    {
        $valor = $request->get('valor');
        $tipo = $request->get('tipo');
        $publicaciones = Publicaciones::obtenerPublicaciones($valor, $tipo);
        return Datatables::of($publicaciones)->make(true);
        
    }
    
    /**
     * Obtiene la primera letra de los titulos de publicaciones, las ordena y no mete repetidas.
     * @return Tabla de primeras letras de publicaciones
     */
    public function obtenerLetras() {
        $letras = Publicaciones::obtenerLetrasSeccion();
        return Datatables::of($letras)->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categorias::orderBy('tx_categoria')->get(['x_idcategoria', 'tx_categoria']);
        $autores = Autores::orderBy('tx_autor')->get(['idautor', 'tx_autor']);
        $vuelta = array('categorias'=>$categorias, 'autores'=>$autores);
        return view('administracion/publicaciones', $vuelta);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'max:300',
            'subtitulo' => 'max:500',
            'asunto' => 'max:200',
            'resumen' => 'max:200',
            'obra' => 'max:200',
            'descriptores' => 'max:500',
            'genero' => 'max:30',
            'isbn' => 'max:80',
            'anno' => 'bail|date_format:Y|before:+1 year',
            'pais' => 'max:50',
            'idioma' => 'max:50',
            'edicion' => 'max:50',
            'fechaPublicacion' => 'bail|date_format:d/m/Y|before:today',
            'paginas' => 'max:16',
            'numPaginas' => 'bail|integer|max:99999999',

        ]);
        $publicacion= ['titulo'=>$request->titulo, 'subtitulo'=>$request->subtitulo,
            'asunto'=>$request->asunto, 'resumen'=>$request->resumen, 'obra'=>$request->obra,
            'descriptores'=>$request->descriptores, 'genero'=>$request->genero,
            'categoria'=>$request->categoria, 'isbn'=>$request->isbn, 'anno'=>$request->anno,
            'pais'=>$request->pais, 'idioma'=>$request->idioma, 'edicion'=>$request->edicion,
            'fechaPublicacion'=>$request->fechaPublicacion, 'paginas'=>$request->paginas,
            'numPaginas'=>$request->numPaginas];
        Publicaciones::guardarPublicacion($publicacion);
        $request->session()->flash('alert-success', 'Se ha creado la publicación');
        return redirect()->action('PublicacionesController@create')->with('alert-success', 'Se ha creado la publicación');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publicacion = Publicaciones::where('x_idpublicacion', $id)->get(['tx_titulo', 'tx_isbn', 'tx_paginas', 'tx_edicion', 'tx_resumen']);
        return $publicacion;
    }

    /**
     * Reenvía los detalles de la publicación indcada por idPublicación por petición JQuery
     * @param Request $request
     */
    public function verDetallePublicacion(Request $request) {
        $idPublicacion= $request->idPublicacion;

        $publicacion = Publicaciones::obtenerInformacionDetalle($idPublicacion);
        return response()->json(array('success' => true, 'publicacion' => $publicacion, 'msg' => 'Se han generado los detalles de la publicacion'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
