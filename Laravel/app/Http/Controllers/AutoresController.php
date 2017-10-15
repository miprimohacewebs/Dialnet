<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Autores;

use Datatables;

class AutoresController extends Controller
{
    public function show(){
        $autores = Autores::all();
        return Datatables::of($autores)->make(true);
    }

}
