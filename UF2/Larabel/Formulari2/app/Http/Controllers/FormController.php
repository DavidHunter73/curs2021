<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $file = $request->file('file');
        $fileName = 'file'.'.'.$file->getClientOriginalExtension();
        $data["file"]=$request->file("file")->storeAs('public', $fileName);
        $data["file"] = $fileName;

        $image = $request->file('image');
        $imageName = 'image'.'.'.$image->getClientOriginalExtension();
        $data["image"]=$request->file("image")->storeAs('public', $imageName);
        $data["image"] = $imageName;

        return view("dades",$data);
    }
}

?>
