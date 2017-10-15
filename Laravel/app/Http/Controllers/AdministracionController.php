<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Publicaciones;
use App\Categorias;
use App\Autores;
use App\Editores;
/**
 * Class AdministracionController para controlar la vista de administración.
 * @package App\Http\Controllers
 */
class AdministracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtiene el número de publicaciones, categorias y autores
        $publicaciones = Publicaciones::obtenerNumeroPublicaciones();
        $categorias = Categorias::obtenerNumeroCategorias();
        $autores = Autores::obtenerNumeroAutores();
        $editores = Editores::obtenerNumeroEditores();
        return view('administracion.administracion', ['publicaciones' => $publicaciones, 'categorias' => $categorias, 'autores' => $autores, 'editores' => $editores]);
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
        //
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
