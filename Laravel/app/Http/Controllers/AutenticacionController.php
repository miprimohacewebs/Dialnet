<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Log;

use App\Http\Requests;

class AutenticacionController extends Controller
{
    public function isAuthenticated(){

        Log::error('checkeo de seguridad: '.Auth::check());
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
