<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Publicaciones;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publi='';
        $publicaciones = Publicaciones::obtenerNumeroPublicaciones();
        if ($publicaciones != '1'){
            $publicaciones = $publicaciones.' Publicaciones';
        }else{
            $publicaciones = $publicaciones.' Publicación';
        }
        return view('index', ['publicaciones' => $publicaciones]);
    }
}
