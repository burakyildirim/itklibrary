<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Libraries;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Transliterator;

class BooksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            $kitaplar = Books::with('library')
                ->select(DB::raw('DATE_FORMAT(book_publishDate, "%Y") as formatted_date'), 'id as bookId', 'book_name', 'book_image', 'book_author', 'book_publisher', 'libraries_id','book_stok','book_visStatus')
                ->orderBy('book_name', 'ASC')
                ->Paginate(7);

        } else {
            $authUserLibraries = Libraries::where('libraries_auth', Auth::id())
                ->select('id')
                ->get();

            $kitaplar = Books::
                whereIn('libraries_id', $authUserLibraries)
                ->select(DB::raw('DATE_FORMAT(book_publishDate, "%Y") as formatted_date'), 'id as bookId', 'book_name', 'book_image', 'book_author', 'book_publisher', 'libraries_id','book_stok','book_visStatus')
                ->orderBy('book_name', 'ASC')
                ->with('library')
                ->paginate(7);
        }

        return view('backend.books.index')->with('kitaplar', $kitaplar);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role == 1) {
            $authUserLibraries = Libraries::select('id', 'libraries_name')->orderBy('libraries_name', 'ASC')->get();
        } else {
            $authUserLibraries = Libraries::where('libraries_auth', Auth::id())
                ->select('id', 'libraries_name')
                ->orderBy('libraries_name', 'ASC')
                ->get();
        }

        // kitap görünürlük durumlarını döndürür.
        $visStatus = Books::VisStatus;

        // kitap dillerini döndürür.
        $languages = Books::Languages;

        return view('backend.books.create', compact('visStatus'), compact('languages'))->with('userLibraries', $authUserLibraries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('book_image')) {
            $request->validate([
                'book_name' => 'required',
                'book_author' => 'required',
                'book_image' => 'required|image|mimes:jpg,jpeg,png|max:1024'
            ]);

            $file_name = uniqid() . '.' . $request->book_image->getClientOriginalExtension();
            $request->book_image->move(public_path('images/books'), $file_name);
        } else {
            $request->validate([
                'book_name' => 'required',
                'book_author' => 'required'
            ]);

            $file_name = null;
        }

        $publishDate = DateTime::createFromFormat('d.m.Y',$request->book_publishDate);

        $book = Books::insert(
            [
                "book_name" => trim(Transliterator::create('tr-upper')->transliterate($request->book_name)),
                "book_author" => trim(Transliterator::create('tr-upper')->transliterate($request->book_author)),
                "book_image" => $file_name,//İşlem
                "book_publisher" => trim(Transliterator::create('tr-upper')->transliterate($request->book_publisher)),
                "book_publishDate" => $publishDate,
                "book_description" => $request->book_description,
                "book_rentStatus" => 1,
                "book_visStatus" => $request->book_visStatus,
                "book_language" => $request->book_language,
                "libraries_id" => $request->libraries_id,
                "book_createdBy" => Auth::id(),
                "book_updatedBy" => Auth::id(),
                "book_stok" => $request->book_stok,
                "created_at" => now(),
                "updated_at" => now()
            ]
        );

        if ($book) {
            return redirect(route('books.index'))->with('success', 'İşlem Başarılı');
        }
        return back()->with('error', 'İşlem Başarısız');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $books = Books::where('id', $id)->first();

        if (Auth::user()->role == 1) {
            $authUserLibraries = Libraries::select('id', 'libraries_name')->orderBy('libraries_name', 'ASC')->get();
        } else {
            $authUserLibraries = Libraries::where('libraries_auth', Auth::id())
                ->select('id', 'libraries_name')
                ->orderBy('libraries_name', 'ASC')
                ->get();
        }

        // kitap görünürlük durumlarını döndürür.
        $visStatus = Books::VisStatus;

        // kitap dillerini döndürür.
        $languages = Books::Languages;

        return view('backend.books.edit', compact('visStatus'), compact('languages'))
            ->with('userLibraries', $authUserLibraries)
            ->with('books', $books);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $publishDate = DateTime::createFromFormat('d.m.Y',$request->book_publishDate);

        if ($request->hasFile('book_image')) {
            $request->validate([
                'book_name' => 'required',
                'book_author' => 'required',
                'book_image' => 'required|image|mimes:jpg,jpeg,png|max:1024'
            ]);

            $file_name = uniqid() . '.' . $request->book_image->getClientOriginalExtension();
            $request->book_image->move(public_path('images/books'), $file_name);

            $book = Books::Where('id', $id)->update(
                [
                    "book_name" => trim(Transliterator::create('tr-upper')->transliterate($request->book_name)),
                    "book_author" => trim(Transliterator::create('tr-upper')->transliterate($request->book_author)),
                    "book_image" => $file_name,//İşlem
                    "book_publisher" => trim(Transliterator::create('tr-upper')->transliterate($request->book_publisher)),
                    "book_publishDate" => $publishDate,
                    "book_description" => $request->book_description,
                    "book_visStatus" => $request->book_visStatus,
                    "book_language" => $request->book_language,
                    "libraries_id" => $request->libraries_id,
                    "book_stok" => $request->book_stok,
                    "book_updatedBy" => Auth::id(),
                    "updated_at" => now()
                ]
            );

            $path='images/books/'.$request->old_file;
            if (file_exists($path))
            {
                @unlink(public_path($path));
            }

        } else {
            $request->validate([
                'book_name' => 'required',
                'book_author' => 'required'
            ]);

            $book = Books::Where('id', $id)->update(
                [
                    "book_name" => trim(Transliterator::create('tr-upper')->transliterate($request->book_name)),
                    "book_author" => trim(Transliterator::create('tr-upper')->transliterate($request->book_author)),
                    "book_publisher" => trim(Transliterator::create('tr-upper')->transliterate($request->book_publisher)),
                    "book_publishDate" => $publishDate,
                    "book_description" => $request->book_description,
                    "book_visStatus" => $request->book_visStatus,
                    "book_language" => $request->book_language,
                    "book_stok" => $request->book_stok,
                    "libraries_id" => $request->libraries_id,
                    "book_updatedBy" => Auth::id(),
                    "updated_at" => now()
                ]
            );

            $file_name = null;
        }


        if ($book) {
            return redirect(route('books.index'))->with('success', 'İşlem Başarılı');
        }
        return back()->with('error', 'İşlem Başarısız');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $libraries = Libraries::findOrFail($id)->delete();
//
//        return response()->json('Silme işlemi başarılı!');
    }

    /**
     * Ekleme ve Düzenleme Ekranında Daha önce eklenmiş yazarları textbox içerisinde listeler
     *
     * @param
     */
    public function yazarAra(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('books')
                ->select('book_author')
                ->distinct()
                ->where('book_author', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

            foreach ($data as $row) {
                $output .= '<li class="yazarLi"><a href="#">' . $row->book_author . '</a></li>';
            }
            $output .= '</ul>';

            return response()->json($output);
        }
    }

    public function yayineviAra(Request $request)
    {
        if ($request->get('publisherQuery')) {
            $query = $request->get('publisherQuery');
            $data2 = DB::table('books')
                ->select('book_publisher')
                ->distinct()
                ->where('book_publisher', 'LIKE', "%{$query}%")
                ->get();
            $output2 = '<ul class="dropdown-menu" style="display:block; position:relative">';

            foreach ($data2 as $row) {
                $output2 .= '<li value="publisher" class="yazarLi"><a href="#">'.$row->book_publisher.'</a></li>';
            }
            $output2 .= '</ul>';

            return response()->json($output2);
        }
    }


}
