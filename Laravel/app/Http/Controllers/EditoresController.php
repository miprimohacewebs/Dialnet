<?php

namespace App\Http\Controllers;
use App\Editores;
use Datatables;

class EditoresController extends Controller
{
    public function show(){
        $editores = Editores::all();
        return Datatables::of($editores)->make(true);
    }

}
