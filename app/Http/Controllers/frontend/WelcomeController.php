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

            $data2 = Books::where('book_name', 'LIKE', "%{$query}%")
                ->where('book_visStatus','=','1')
                ->select('book_name','id','libraries_id')
                ->with('library')
                ->get();

//
//            $data2 = Books::where(function ($name) {
//                $query="asd";
//                    $name->where('book_visStatus', '=', 1)
//                    ->where('book_name', 'LIKE', "%{$query}%");
//            })->orWhere(function ($author) {
//                $author->where('book_visStatus', '=', 1)
//                    ->where('book_author', 'LIKE', "%{$query}%");
//            })
//                ->select('book_name', 'id', 'libraries_id','book_visStatus')
//                ->with('library')
//                ->get();


            $output2 = '<ul style="position:relative; font-size:18px;">';

            foreach ($data2 as $row) {
                $output2 .= '<li value="publisher" class="yazarLi"><a href="kitap/' . $row->id . '">' . $row->book_name . '</a>' . '<span style="">' . ' (' . $row->library['libraries_name'] . ')' . '</span>' . '</li>';
            }
            $output2 .= '</ul>';

            return response()->json($output2);
        }
    }
}
