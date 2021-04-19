<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\EBooks;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    public function index(){
        $allEbooks = EBooks::orderBy('id','DESC')->get();
        return view('frontend.ebook.index',compact('allEbooks',$allEbooks));
    }

    public function show($id){
        $ebook = EBooks::where('unique_key', $id)->first();
        return view('frontend.ebook.show')->with('ebookDetay',$ebook);
    }
}
