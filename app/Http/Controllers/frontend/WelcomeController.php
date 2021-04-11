<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('frontend.welcome.index');
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
                ->get();

            $output2 = '<ul style="position:relative; font-size:18px;">';
            //'/'. $row->id .'' .

            foreach ($data2 as $row) {
                $output2 .= '<li value="publisher" class="yazarLi"><a href="kitap/' . $row->id .'/'. $row->book_slug .'' . '">' . $row->book_name . '</a>' . '<span style="">' . ' (' . $row->library['libraries_name'] . ')' . '</span>' . '</li>';
            }
            $output2 .= '</ul>';

            return response()->json($output2);
        }
    }
}
