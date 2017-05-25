<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AppIndexController extends Controller
{
    public function index(){
        $title = '22223123';
        return view('App.index',compact('title'));
    }
}
