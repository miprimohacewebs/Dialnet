<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Autores;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Exception;


use Datatables;

class AutoresController extends Controller
{
    public function show(){
        $autores = Autores::all();
        return Datatables::of($autores)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('administracion/autores');
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
            'nombreAutor' => 'max:100',
        ]);

        if ($validator->fails()){
            return redirect()->to('autoresadmin')
                ->withErrors($validator)
                ->withInput();
        }

        $autor= ['autor'=>$request->nombreAutor];
        Autores::guardarAutor($autor);

        $request->session()->flash('alert-success', 'Se ha creado el/la autor/a correctamente');
        return redirect()->action('AutoresController@create')->with('alert-success', 'Se ha creado el/la autor/a correctamente');
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
            Autores::destroy($id);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->action('AutoresController@create')->with('alert-error', 'Ha ocurrido un error al borrar el/la autor/a, puede ser que esté relacionada con alguna publación. Por favor revise las publicaciones y observe si hay alguna con ese/a autor/a');
        }

        return redirect()->action('AutoresController@create')->with('alert-success', 'Se ha borrado el/la autor/a correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $autor = Autores::where('idautor', $id)->first();
        $autorVuelta= [ 'autor'=>$autor['tx_autor'],'idAutor'=>$autor['idAutor']];
        $vuelta = array('autor' => $autorVuelta);
        return view('administracion/autores', $vuelta);
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
                'nombreAutor' => 'max:100',
            ]);
            if ($validator->fails()){
                return redirect()->to('autoresadmin')
                    ->withErrors($validator)
                    ->withInput();
            }

            $autor = array('autor'=>$request->nombreAutor, 'idAutor'=>$request->idAutor);
            Autores::actualizarAutor($autor);

            $request->session()->flash('alert-success', 'Se ha modificado el/la autor/a');
            return redirect()->action('AutoresController@create')->with('alert-success', 'Se ha modificado el/la autor/a');
        }catch (Exception $e){
            Log::error($e);
            return redirect()->action('AutoresController@create')->with('alert-error', 'Ha ocurrido un error al modificar el/la autor/a');
        }
    }

}
