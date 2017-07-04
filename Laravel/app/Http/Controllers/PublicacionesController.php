<?php
namespace App\Http\Controllers;
use App\Publicaciones;
use Illuminate\Http\Request;


class PublicacionesController extends Controller
{

    public function index()
    {
        return view('index');
    }
    
    public function getPublicaciones()
    {
        $publicaciones = Publicaciones::select(['x_idpublicacion','tx_titulo','tx_resumen','fh_fechapublicacions']);
 
        return Datatables::of($publicaciones)->make(true);
    }
}



