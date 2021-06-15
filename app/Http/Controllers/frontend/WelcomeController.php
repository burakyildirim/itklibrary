<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\DigitalBooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $sonKitaplar = Books::where('book_visStatus','=','1')
            ->with('library')
            ->orderBy('created_at','DESC')
            ->select('id','book_slug','book_name','book_description','book_image','book_author')
            ->limit(3)
            ->get();

        $sonDijitalYayinlar = DigitalBooks::with('levels')->limit('21')->get();

        return view('frontend.welcome.index')->with('sonEklenenKitaplar',$sonKitaplar)->with('sonDijitalYayinlar',$sonDijitalYayinlar);
    }

    public function kitapAra(Request $request)
    {
        if ($request->get('query')) {

            $query = $request->get('query');

            //ÇALIŞAN
//            $data2 = Books::where('book_visStatus','=','1')
//                ->where('book_name','LIKE','%'.$query.'%')
//                ->orwhere('book_author','LIKE','%'.$query.'%')
//                ->select('book_name','id','libraries_id','book_slug','book_author')
//                ->with('library')
//                ->get();

            // kitap adı yada yazar araması -- visstatus 1 koşulu
                $data2 = Books::where(function ($query2) use($query) {
                    $query2->where('book_visStatus','=','1')
                        ->Where('book_name','LIKE','%'.$query.'%');
                })->orwhere(function ($query2) use($query) {
                    $query2->where('book_visStatus','=','1')
                        ->Where('book_author','LIKE','%'.$query.'%');
                })
                ->select('book_name','id','libraries_id','book_slug','book_author')
                ->with('library')
                ->limit(6)
                ->get();

            $output2 = '<ul style="position:relative; font-size:18px;">';
            //'/'. $row->id .'' .

            if ($data2->count()==0){
                $output2 .= '<li value="publisher" class="yazarLi"><span style="">Herhangi bir sonuç bulunamadı!</span></li>';
            }

            $loopSayi = 0;
            foreach ($data2 as $row) {
                $output2 .= '<li value="publisher" class="yazarLi"><a href="kitap/' . $row->id .'/'. $row->book_slug .'' . '">' . $row->book_name . '</a>' . '<span style="">' . ' (' . $row->book_author . ')' . '<p class="text-muted" style="font-size:11px;">' .$row->library['libraries_name'] . '</p>' . '</span>' . '</li>';

//                library['libraries_name']

                if ($loopSayi!=$data2->count()-1){
                    $output2 .= '<hr/>';
                }
                $loopSayi++;
            }
            $output2 .= '</ul>';

            return response()->json($output2);
        }
    }
}
