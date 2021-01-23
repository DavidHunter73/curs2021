<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function show() {
        return view("form");
    }

    public function postform(Request $request){

        /*$aut="usuario no autentificado";
        if(\Auth::check()){
            $aut="usuario autentificado";
        }*/

        if($request->has("file")){
            return view("welcome");
        }

        if($request->has("image")){
            return view("welcome");
        }

        if($request->filled("name")){
            
        }

        return view('dades')
            ->with('name', $request->input("name")) 
            ->with('mail', $request->input("mail"))
            ->with('nif', $request->input("nif"))
            ->with('password', $request->input("password"))
            /*->with('aut', $aut)*/;
    }
}

?>
