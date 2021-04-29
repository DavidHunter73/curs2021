<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Message;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use App\Events\NewCommentNotification;
use App\Events\NewMessageNotification;
use App\Events\ReloadLikes;
use App\Events\UserConnection;

class MuroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user() != null){
            $data["user_id"] = Auth::user()->id;
            $data["user_name"] = Auth::user()->name;
            return view("muro", $data);
        } else {
            return redirect()->route('public');
        }
    }


    public function send(Request $request){
        $message = new Message;
        $message->from = Auth::user()->id;
        $message->messages = $request->mensaje;
        $message->likes = 0;
        $message->image = "";
        
        /*if($request->imagen == null){
            $message->image = "";
        } else {
            Storage::disk('local')->put("Imagen".$message->id.".png" ,$request->imagen);
            $message->image = "Imagen".$message->id.".png";
        }*/
        
        $message->save();

        $user = User::find($message->from);

        event(new NewMessageNotification($message, $user));
    }

    public function get(){
        $messages = Message::all();
        $user = User::all();
        $likes = Like::all();
        $comments = Comment::all();

        $all = [$messages, $user, $likes, $comments];
        
        return $all;
    }


    public function like(Request $request){
        $existe = false;

        $likes = Like::all();

        if(count ($likes) > 0){
            foreach ($likes as $valor){
                if($valor->user_id == $request->usuario
                &&
                $valor->message_id == $request->mensaje)
                {
                    $valor->delete();
                    $message = Message::find($request->mensaje);
                    $message->likes--;
                    $message->save();

                    $existe = true;
                }          
            }
        }

        if(!$existe){
            $like = new Like;
            $like->user_id = $request->usuario;
            $like->message_id = $request->mensaje;
            $like->save();
            
            $message = Message::find($request->mensaje);
            $message->likes++;
            $message->save();
        }

        event(new ReloadLikes());
    }


    public function comment(Request $request){
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->message_id = $request->mensaje;
        $comment->comments = $request->comentario;
        
        $comment->save();

        event(new NewCommentNotification($comment));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
