<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\DigitalBooks;
use App\Models\Levels;
use App\Models\EBooks;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Zip;

class DigitalBooksController extends Controller
{
    public function index(){
        $digitalBooks = DigitalBooks::with('levels')->Paginate(12);

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
        $digitalBook->delete();

        $path = public_path('zips/'.$digitalBook->unique_key);

        if (File::exists($path)) {
            File::deleteDirectory($path);
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

        $this->validate($request, [
            'ebooks_name' => ['required', 'string', 'max:100'],
            'ebooks_description' => ['required', 'string'],
            // The user should select at least one category
            'levels_ebook' => ['required', 'array', 'min:1'],
            // 'ebooks_levels.*' => ['required', 'integer', 'exists:e_books,id'],
        ]);

        $ebook_image = null;
        if ($request->hasFile('ebook_image')) {
            $fileName = $randomFileName.'.'.$request->ebook_image->getClientOriginalExtension();
            $ebook_image = $fileName;
            $request->ebook_image->move(public_path('images/ebooks/'),$fileName);
        }

        $ebook = new DigitalBooks();
        $ebook->unique_key = $randomFileName;
        $ebook->ebooks_name = $request->ebooks_name;
        $ebook->ebooks_description = $request->ebooks_description;
        $ebook->ebooks_slug = Str::slug($request->ebooks_name);
        $ebook->ebooks_image = $ebook_image;
        $ebook->save();

        $ebook->levels()->attach($request->levels_ebook);

        return back()->with("success", "Dijital yayın ekleme işlemi başarılı!");
    }
}
