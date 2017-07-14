<?php

namespace App\Http\Controllers;

use App\Categorias;
use Datatables;

class CategoriasController extends Controller
{
    public function show(){
        $categorias = Categorias::all();
        return Datatables::of($categorias)->make(true);
    }
}
