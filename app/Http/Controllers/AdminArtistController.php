<?php

namespace App\Http\Controllers;

use Request,Session;
use App\Http\Model\ArtistModel as Artist;

class AdminArtistController extends Controller
{
    public function index(){
        $title = "艺术家管理";
        $data = Artist::paginate(25);
        return view('Admin.Artist.index',compact('title','data'));
    }
}
