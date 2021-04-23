<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\DigitalBooks;
use App\Models\Levels;
use App\Models\EBooks;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Zip;

class DigitalBooksController extends Controller
{
    public function index(){
        $digitalBooks = DigitalBooks::with('levels')->Paginate(12);
//        dd($digitalBooks);

        return view('backend.ebooks.index',compact('digitalBooks',$digitalBooks));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $digitalBook = DigitalBooks::find($id);
        $digitalBook->levels()->detach();

//        $book->increment('book_stok',1);
        $digitalBook->delete();

        if (File::exists(public_path('zips/'.$digitalBook->unique_key.'/'))) {
            unlink(public_path('zips/'.$digitalBook->unique_key.'/'));
            return response()->json('Silme işlemi başarılı!');
        }

        return response()->json('Silme işlemi başarısız!!!!!!!');

    }

    public function create(){
        $classLevels = Levels::orderBy('id','ASC')->get();

        return view('backend.ebooks.create', compact('classLevels', $classLevels));
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

            // rename(public_path('zips/'.$randomFileName.'/files/page'),public_path('zips/'.$randomFileName.'/files/mobile'));
            // rename(public_path('zips/'.$randomFileName.'/files/extfiles'),public_path('zips/'.$randomFileName.'/files/mobile-ext'));

            // File::copy(public_path('zips/ebookFiles/index.php'), public_path('zips/'.$randomFileName.'/index.html'));
            // File::copyDirectory(public_path('zips/ebookFiles/mobile'), public_path('zips/'.$randomFileName.'/mobile'));
        }

        $this->validate($request, [
            'ebooks_name' => ['required', 'string', 'max:100'],
            'ebooks_description' => ['required', 'string'],
            // The user should select at least one category
            'levels_ebook' => ['required', 'array', 'min:1'],
            // 'ebooks_levels.*' => ['required', 'integer', 'exists:e_books,id'],
        ]);

        $ebook = new DigitalBooks();
        $ebook->unique_key = $randomFileName;
        $ebook->ebooks_name = $request->ebooks_name;
        $ebook->ebooks_description = $request->ebooks_description;
        $ebook->ebooks_slug = Str::slug($request->ebooks_name);
        $ebook->ebooks_image = null;
        $ebook->save();

        $ebook->levels()->attach($request->levels_ebook);

//
//        $ebookInsert = EBooks::insert([
//            'unique_key' => ,
//            'ebooks_name' => $request->ebooks_name,
//            'ebooks_description' => $request->ebooks_description,
//            'ebooks_image' => null
//        ]);
//
//        if ($ebookInsert){
//            return back()->with("success", "E-Kitap ekleme başarılı!");
//        }

        return back()->with("success", "Dijital yayın ekleme işlemi başarılı!");
    }
}
