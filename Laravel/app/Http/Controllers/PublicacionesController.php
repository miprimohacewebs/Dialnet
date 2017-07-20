<?php

namespace App\Http\Controllers;
use App\Publicaciones;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $publicacion = Publicaciones::where('x_idpublicacion','=',$idPublicacion)->get();
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
