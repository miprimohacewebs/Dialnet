<?php

namespace App\Http\Controllers;

use App\Categorias;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use Exception;


class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categorias.index');
    }

    public function show(){
        $categorias = Categorias::all();
        return Datatables::of($categorias)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoria' => 'max:100',
        ]);

        $categoria= ['categoria'=>$request->categoria];
        Categorias::guardarCategoria($categoria);

        $request->session()->flash('alert-success', 'Se ha creado la categoria correctamente');
        return redirect()->action('CategoriasController@create')->with('alert-success', 'Se ha creado la categoria correctamente');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categorias ="pepe";
        $vuelta = array('categorias' => $categorias);
        return view('administracion/categorias', $vuelta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Categorias::destroy($id);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->action('AdministracionController@index')->with('alert-error', 'Ha ocurrido un error al borrar la categoria, puede ser que esté relacionada con alguna publación. Por favor revise las publicaciones y observe si hay alguna con esa categoría');
        }

        return redirect()->action('AdministracionController@index')->with('alert-success', 'Se ha borrado la categoria correctamente');
    }
}
