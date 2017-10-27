<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactFormRequest $request)
    {
        Mail::send('emails.contact',
            array(
                Mail::send('emails.contact',
                    array(
                        'nombre' => $request->get('nombre'),
                        'apellidos' => $request->get('apellidos'),
                        'email' => $request->get('email'),
                        'mensaje' => $request->get('mensaje')
                    ), function ($message) {
                        $message->from('zambranosoft@gmail.com');
                        $message->to('zambranosoft@gmail.com', 'Admin')->subject('Formulario de contacto de Cibermov');
                    })));

        return redirect()->route('contacto')->with('mensaje', 'Ha contactado con Cibermov, en breve tendrá una respuesta a su consulta.');
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
