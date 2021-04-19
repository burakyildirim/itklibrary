<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\EBooks;
use Illuminate\Http\Request;
use Zip;
use File;

class EBooksController extends Controller
{
    public function index(){
        return view('backend.ebooks.index');
    }

    public function create(){

        return view('backend.ebooks.create');
    }

    public function store(Request $request){
        $randomFileName= uniqid();
        if ($request->hasFile('ebook_file')) {
            $fileName = $randomFileName.'.'.$request->ebook_file->getClientOriginalExtension();

            $request->ebook_file->move(public_path('zips/'),$fileName);

            $zip = Zip::open(public_path('zips/'.$fileName));
            $zip->extract(public_path('zips/'.$randomFileName.'/'));

            if (file_exists(public_path('zips/'.$fileName))){
                @unlink(public_path('zips/'.$fileName));
            }

//            rename(public_path('zips/'.$randomFileName.'/files/page'),public_path('zips/'.$randomFileName.'/files/mobile'));
//            rename(public_path('zips/'.$randomFileName.'/files/extfiles'),public_path('zips/'.$randomFileName.'/files/mobile-ext'));

//            File::copy(public_path('zips/ebookFiles/index.php'), public_path('zips/'.$randomFileName.'/index.html'));
//            File::copyDirectory(public_path('zips/ebookFiles/mobile'), public_path('zips/'.$randomFileName.'/mobile'));
        }

        $ebookInsert = EBooks::insert([
            'unique_key' => $randomFileName,
            'ebooks_name' => $request->ebooks_name,
            'ebooks_description' => $request->ebooks_description,
            'ebooks_image' => null
        ]);

        if ($ebookInsert){
            return back()->with("success", "E-Kitap ekleme başarılı!");
        }

        return back()->with("error", "E-Kitap ekleme işlemi başarısız!");
    }
}
