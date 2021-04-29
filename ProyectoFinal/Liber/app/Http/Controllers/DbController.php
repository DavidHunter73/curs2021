<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DbController extends Controller
{
    //
    public function index(){
        return User::all();
    }
}
