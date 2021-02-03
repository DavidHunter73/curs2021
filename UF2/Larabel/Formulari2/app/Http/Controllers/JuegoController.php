<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;

class JuegoController extends Controller
{
    
    public function db(Request $request){
        $data["juegos"]= Juego::all();

        return view('juegosTable', $data);
    }

    public function storeForm(Request $request){
        return view('createJuego');
    }

    public function editForm($id){       

        $data['id'] = $id;

        return view('editarJuego', $data);
    }

    public function store(Request $request)
    {
        // Validate the request...

        $juego = new Juego;

        $juego->nombre = $request->nombre;
        $juego->genero = $request->genero;
        $juego->empresa = $request->empresa;

        $juego->save();

        return redirect('/dadesTable');
    }

    public function delete($id)
    {
        Juego::destroy($id);


        return redirect('/dadesTable');
    }


    public function edit($id, Request $request){

        $juego = Juego::find($id);
        $juego->nombre = $request->nombre;
        $juego->genero = $request->genero;
        $juego->empresa = $request->empresa;

        $juego->save();

        return redirect('/dadesTable');

    }


}
