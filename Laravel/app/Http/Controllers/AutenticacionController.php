<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Http\Requests;

class AutenticacionController extends Controller
{
    public function isAuthenticated(){


        if (Auth::check()){
            return "true";
        }else{
            return "false";
        }

    }

    public function getName(){
        return Auth::user()->name;
    }
}
