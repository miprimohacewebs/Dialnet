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
        return view('administracion/categorias');
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
            return redirect()->action('CategoriasController@create')->with('alert-error', 'Ha ocurrido un error al borrar la categoria, puede ser que esté relacionada con alguna publación. Por favor revise las publicaciones y observe si hay alguna con esa categoría');
        }

        return redirect()->action('CategoriasController@create')->with('alert-success', 'Se ha borrado la categoria correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categorias::where('x_idcategoria', $id)->first();
        $categoriaVuelta= [ 'categoria'=>$categoria['tx_categoria'],'idCategoria'=>$categoria['x_idcategoria']];
        $vuelta = array('categoria' => $categoriaVuelta);
        return view('administracion/categorias', $vuelta);
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
        try {
            $validator = Validator::make($request->all(), [
                'categoria' => 'max:100',
             ]);
            if ($validator->fails()){
                return redirect()->to('categoriasadmin')
                    ->withErrors($validator)
                    ->withInput();
            }

            $categoria = array('categoria'=>$request->categoria, 'idCategoria'=>$request->idCategoria);
            Categorias::actualizarCategoria($categoria);

            $request->session()->flash('alert-success', 'Se ha modificado la categoría');
            return redirect()->action('CategoriasController@create')->with('alert-success', 'Se ha modificado la categoría');
        }catch (Exception $e){
            Log::error($e);
            return redirect()->action('CategoriasController@create')->with('alert-error', 'Ha ocurrido un error al modificar la categoría');
        }
    }

    public function mostrarCategorias (Request $request){
        $annos = $request->get('annos');
        $autores = $request->get('autores');
        $categorias = $request->get('categorias');
        $descriptores = $request->get('descriptores');
        $busqueda = $request->get('busqueda');
        if ($annos===''){
            $annos=null;
        }
        if ($autores===''){
            $autores = null;
        }
        if ($categorias===''){
            $categorias=null;
        }
        if ($descriptores===''){
            $descriptores=null;
        }
        $categorias = Categorias::obtenerCategoriasDatatable($annos, $autores, $categorias, $descriptores, $busqueda);
        return Datatables::of($categorias)->make(true);
    }
}
