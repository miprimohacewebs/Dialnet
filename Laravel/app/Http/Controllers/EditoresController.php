<?php

namespace App\Http\Controllers;
use App\Editores;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Exception;

class EditoresController extends Controller
{
    public function show(){
        $editores = Editores::all();
        return Datatables::of($editores)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('administracion/editores');
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
            'editor' => 'max:100',
        ]);

        if ($validator->fails()){
            return redirect()->to('editoresadmin')
                ->withErrors($validator)
                ->withInput();
        }

        $editor= ['editor'=>$request->editor];
        Editores::guardarEditor($editor);

        $request->session()->flash('alert-success', 'Se ha creado el/la editor/a correctamente');
        return redirect()->action('EditoresController@create')->with('alert-success', 'Se ha creado el/la editor/a correctamente');
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
            Editores::destroy($id);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->action('EditoresController@create')->with('alert-error', 'Ha ocurrido un error al borrar el/la editor/a, puede ser que esté relacionada con alguna publación. Por favor revise las publicaciones y observe si hay alguna con ese/a editor/a');
        }

        return redirect()->action('EditoresController@create')->with('alert-success', 'Se ha borrado el/la editor/a correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editor = Editores::where('x_ideditor', $id)->first();
        $editorVuelta= [ 'editor'=>$editor['tx_editor'],'idEditor'=>$editor['x_ideditor']];
        $vuelta = array('editor' => $editorVuelta);
        return view('administracion/editores', $vuelta);
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
                'editor' => 'max:100',
            ]);
            if ($validator->fails()){
                return redirect()->to('editoresadmin')
                    ->withErrors($validator)
                    ->withInput();
            }

            $editor = array('editor'=>$request->editor, 'idEditor'=>$request->idEditor);
            Editores::actualizarEditor($editor);

            $request->session()->flash('alert-success', 'Se ha modificado el/la editor/a');
            return redirect()->action('EditoresController@create')->with('alert-success', 'Se ha modificado el/la editor/a');
        }catch (Exception $e){
            Log::error($e);
            return redirect()->action('EditoresController@create')->with('alert-error', 'Ha ocurrido un error al modificar el/la editor/a');
        }
    }

}
