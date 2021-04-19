<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EBooksController extends Controller
{
    public function index(){
        return view('backend.ebooks.index');
    }

    public function create(){
        return view('backend.ebooks.create');
    }

    public function store(Request $request){

    }
}
