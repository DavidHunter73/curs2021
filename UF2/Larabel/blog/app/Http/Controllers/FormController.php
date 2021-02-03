<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function show() {
        return view('form');
    }

    public function postform(Request $request){

        /*$aut="usuario no autentificado";
        if(\Auth::check()){
            $aut="usuario autentificado";
        }*/


        $validateData = $request->validate([
            'name' => 'required|string',
            'mail' => 'required|email',
            'nif' => 'required|string',
            'file' => 'required|between:0,1024',
            'image' => 'required|dimensions:min_width=1920,min_height=1080'
        ]);

        $data["name"]=$request->input("name");
        $data["mail"]=$request->input("mail");
        $data["nif"]=$request->input("nif");
        $data["file"]=$request->input("file");
        $data["image"]=$request->input("image");
   
        return view("dades",$data);
    }
}

?>
