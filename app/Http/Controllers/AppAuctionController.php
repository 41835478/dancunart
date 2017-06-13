<?php

namespace App\Http\Controllers;

use Request;

class AppAuctionController extends Controller
{
    public function index(){
        $data = Request::all();
        dd($data);
    }
}
