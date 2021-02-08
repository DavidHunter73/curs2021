<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Juego;

class JuegoController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function index()
 {
    //
    $juegos=Juego::orderBy('id','DESC')->paginate(3);
    return view('Juego.index',compact('juegos'));
 }
 /**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function create()
 {
    //
    return view('Juego.create');
 }
 /**
 * Store a newly created resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
 public function store(Request $request)
 {
    //
    $this->validate($request,[ 'nombre'=>'required', 'empresa'=>'required', 'genero'=>'required']);
    Juego::create($request->all());
    return redirect()->route('juego.index')->with('success','Registro creado satisfactoriamente');
}
 /**
 * Display the specified resource.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
 public function show($id)
 {
    $juegos=Juego::find($id);
    return view('juego.show',compact('juegos'));
 }
 /**
 * Show the form for editing the specified resource.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
 public function edit($id)
 {
    //
    $juego=juego::find($id);
    return view('juego.edit',compact('juego'));
 }
 /**
 * Update the specified resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @param int $id
 * @return \Illuminate\Http\Response
 */
 public function update(Request $request, $id) {
    //
    $this->validate($request,[ 'nombre'=>'required', 'empresa'=>'required', 'genero'=>'required']);
    juego::find($id)->update($request->all());
    return redirect()->route('juego.index')->with('success','Registro actualizado
    satisfactoriamente');
 }
 /**
 * Remove the specified resource from storage.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
 public function destroy($id)
 {
    //
    Juego::find($id)->delete();
    return redirect()->route('juego.index')->with('success','Registro eliminado satisfactoriamente');
 }
}
