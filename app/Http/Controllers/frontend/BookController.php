<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Rents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index($id){
        $kitap = Books::where('id','=',$id)->where('book_visStatus','=','1')
            ->with('library')
            ->first();

        $myrents = Rents::where('books_id',$id)->orderby('rentEndDate','DESC')->get();

        if ($kitap==null){
            return back();
        }else{
            return view('frontend.book.index')->with('kitapDetay', $kitap)->with('myrents', $myrents);
        }
    }

    public function bookRez($id){

        $rezerveIstek = DB::table('rents')
            ->insert([
                'users_id' => Auth::id(),
                'books_id' => $id,
                'rent_auth' => Auth::id(),
                'rentStartDate' => now(),
                'rentEndDate' => now()->addWeek(2),
                'rent_status' => 1
            ]);

        if ($rezerveIstek){
            $kitapRentStatusGuncelle = Books::where('id',$id)->update([
                'book_rentStatus' => 0
            ]);

            return response()->json('Rezervasyon işlemi başarılı!');
        }else{
            return response()->json('Rezervasyon işlemi başarısız!!!');
        }



    }
}
