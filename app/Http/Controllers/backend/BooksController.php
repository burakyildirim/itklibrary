<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Libraries;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Imagick;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\Console\Input\Input;
use Transliterator;

class BooksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginationNumber = 12;
        if (Auth::user()->role == 1) {
            // Arama kutusundan veri geliyor mu onu kontrol ediyorum. geliyorsa $kitaplar LIKE sorgusu ile dönüyor. For Paginate function

            $kitaplar = Books::with('library')
                ->where('book_name','LIKE','%'.$request->q.'%')
                ->orWhere('book_author','LIKE','%'.$request->q.'%')
                ->select(DB::raw('DATE_FORMAT(book_publishDate, "%Y") as formatted_date'), 'id as bookId', 'book_name', 'book_image', 'book_author', 'book_publisher', 'libraries_id', 'book_stok', 'book_visStatus', 'book_raf','book_sira')
                ->orderBy('book_name', 'ASC')
                ->Paginate($paginationNumber);
        } else {
            $authUserLibraries = Libraries::where('libraries_auth', Auth::id())
                ->select('id')
                ->get();
//            dd($authUserLibraries);


            $kitaplar = Books::
                where(function ($y) use ($request, $authUserLibraries){
                    $y->where('book_name', 'LIKE','%'.$request->q.'%')->whereIn('libraries_id', $authUserLibraries);
                })
                    ->orWhere(function ($w) use($request, $authUserLibraries){
                    $w->where('book_author', 'LIKE','%'.$request->q.'%')->whereIn('libraries_id', $authUserLibraries);
                })
                ->select(DB::raw('DATE_FORMAT(book_publishDate, "%Y") as formatted_date'), 'books.id as bookId', 'book_name', 'book_image', 'book_author', 'book_publisher', 'libraries_id', 'book_stok', 'book_visStatus', 'book_raf','book_sira')
                ->orderBy('book_name', 'ASC')
                ->with('library')
                ->paginate($paginationNumber);

//            dd($kitaplar);
        }


//        $site = 'https://www.idefix.com/Kitap/Hayvan-Ciftligi/Edebiyat/Roman/Dunya-Roman/urunno=0000000105409';
//        $veri = file_get_contents($site);
//        preg_match_all("@<a href=\"javascript:\" class=\"showZoomable ImageZoom\">(.*?)</a>@is",$veri,$kitapResim);
//        preg_match_all("@data-src=\"(.*?)\"@is",$kitapResim[1][0],$kitapResimLink);
//        $idefixImage = file_get_contents($kitapResimLink[1][0]);
//        $kitapUzanti = explode(".",$kitapResimLink[1][0]);
//
//        dd($kitapUzanti[count($kitapUzanti)-1]);

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

    public function kitapYurduSearch($link){
        $site2 = rawurldecode($link);
        $site = $site2;
        $veri = file_get_contents($site);

        preg_match_all('@<div class="product-description">(.*?)</div>@is', $veri, $aciklama);
        preg_match_all('@<h1 class="mt0" style="margin-bottom: 10px !important;">(.*?)</h1>@is', $veri, $kitapAdi);
        preg_match_all("@<div class=\"publisher\"><span>Yayınevi</span>(.*?)</div>@is",$veri,$publisher);

        // idefix den kitap resimlerinin çekilmesi //
        preg_match_all("@<a href=\"javascript:\" class=\"showZoomable ImageZoom\">(.*?)</a>@is",$veri,$kitapResim);
        preg_match_all("@data-src=\"(.*?)\"@is",$kitapResim[1][0],$kitapResimLink);
        // idefix den kitap resimlerinin çekilmesi //

        $metin = explode('<div class="row">',$aciklama[1][0]);

        $siteBasligi = preg_match_all("@<title>(.*?)</title>@is",$veri,$title);
        $yazarAdi = explode('-',$title[1][0]);
        $sonKitapAdi = explode(',',$yazarAdi[0]);
        $sonSonKitapAdi = trim($sonKitapAdi[0]);
        $sonSonYazarAdi = trim($sonKitapAdi[1]);

        $publisherAdi = explode('>',$publisher[1][0]);
        $sonSonYayineviAdi = trim(explode('<',$publisherAdi[1])[0]);

//        $search  = array('&uuml;', '&ccedil;', '&Ouml;', 'D', 'E');
//        $replace = array('ü', 'ç', 'Ö', 'E', 'F');

        $idefixImage = file_get_contents($kitapResimLink[1][0]);
        $kitapUzanti = explode(".",$kitapResimLink[1][0]);

        $dosyaAdi = uniqid().'.'.$kitapUzanti[count($kitapUzanti)-1];
        file_put_contents(public_path('images/books/'.$dosyaAdi), $idefixImage);

        return response()->json([
            'metin' => $metin,
            'kitapAdi' => $sonSonKitapAdi,
            'yazarAdi' => $sonSonYazarAdi,
            'yayineviAdi' => $sonSonYayineviAdi,
            'kitapResimLink' => $kitapResimLink,
            'dosyaAdi' => $dosyaAdi,
            'kitapResimUzanti' => $kitapUzanti[count($kitapUzanti)-1]
        ]);
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

            if ($request->hiddenResimDosyasi!=null){
                $file_name = $request->hiddenResimDosyasi;
            }else{
                $file_name = null;
            }
        }

//        $bookSlug = Str::slug($request->book_name);
//        $slugExists = Books::where('book_slug',Str::slug($request->book_name))->exists();
//        if ($slugExists){
//            $bookSlug = $request->book_slug.'-'.mt_rand(1000000000, 9999999999);
//        }

        $publishDate = DateTime::createFromFormat('d.m.Y', $request->book_publishDate);

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
                "book_slug" => Str::slug($request->book_name),
                "book_raf" => $request->book_raf,
                "book_sira" => $request->book_sira,
                "book_isbn" => $request->book_isbn,
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
        $publishDate = DateTime::createFromFormat('d.m.Y', $request->book_publishDate);
        $bookSlug = $request->book_slug;
        if ($bookSlug == null) {
            $bookSlug = Str::slug($request->book_name);
        }


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
                    "book_slug" => $bookSlug,
                    "book_raf" => $request->book_raf,
                    "book_sira" => $request->book_sira,
                    "book_isbn" => $request->book_isbn,
                    "book_stok" => $request->book_stok,
                    "book_updatedBy" => Auth::id(),
                    "updated_at" => now()
                ]
            );

            $path = 'images/books/' . $request->old_file;
            if (file_exists($path)) {
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
                    "book_slug" => $bookSlug,
                    "book_raf" => $request->book_raf,
                    "book_sira" => $request->book_sira,
                    "book_isbn" => $request->book_isbn,
                    "libraries_id" => $request->libraries_id,
                    "book_updatedBy" => Auth::id(),
                    "updated_at" => now()
                ]
            );

            $file_name = null;
        }


        if ($book) {
//            return back()->with('success', 'Güncelleme işlemi başarılı!');

            return redirect(route('books.index'))->with('success', 'Güncelleme işlemi başarılı!');
        }
        return back()->with('error', 'Güncelleme işlemi başarısız!');
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
                $output2 .= '<li value="publisher" class="yazarLi"><a href="#">' . $row->book_publisher . '</a></li>';
            }
            $output2 .= '</ul>';

            return response()->json($output2);
        }
    }

    public function myqr($id)
    {
        $kitap = Books::find($id);
        $qrLink = url('/') . '/kitap/' . $kitap->id . '/' . $kitap->book_slug;
        $logoUrl = url('/images/itk_arma.png');
        $qrKaydet = base64_encode(QrCode::size(400)->format('png')->merge($logoUrl, 0.3, true)->errorCorrection('H')->generate($qrLink));
//        $qrpath = public_path('images/qrcodes/'.$kitap->id.'.png');

        return response()->json($qrKaydet);
    }

}
