<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\DigitalBooks;
use App\Models\EBooks;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    public function index(){
        $allEbooks = DigitalBooks::orderBy('id','DESC')->get();
        return view('frontend.ebook.index',compact('allEbooks',$allEbooks));
    }

    public function show($id){
        $ebook = DigitalBooks::where('unique_key', $id)->first();
        return view('frontend.ebook.show')->with('ebookDetay',$ebook);
    }
}
