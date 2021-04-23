<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\DigitalBooks;
use App\Models\EBooks;
use App\Models\Levels;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    public function index($slug=null){
        $allClassLevels = Levels::orderBy('id','ASC')->get();
        if ($slug!=null){
            $allEbooks = DigitalBooks::with('levels')
                ->whereHas('levels',function ($q) use($slug){
                    $q->where('level_slug',$slug);
            })->orderBy('id','DESC')->paginate(12);
        }else{
            $allEbooks = DigitalBooks::orderBy('id','DESC')->paginate(12);
        }

        return view('frontend.ebook.index',compact('allEbooks',$allEbooks))->with('allClassLevels',$allClassLevels);
    }

    public function show($id){
        $ebook = DigitalBooks::where('unique_key', $id)->first();
        return view('frontend.ebook.show')->with('ebookDetay',$ebook);
    }
}
