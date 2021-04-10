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
    public function index($id, $slug){

        $kitap = Books::where('id','=',$id)->where('book_slug',$slug)->where('book_visStatus','=','1')
            ->with('library')
            ->first();

        $isReservatedByMe = Rents::where('books_id',$id)->where('users_id',Auth::id())->whereIn('rent_status',['1','2','4'])->exists();

        $reservation =  Rents::where('books_id',$id)->where('users_id',Auth::id())->whereIn('rent_status',['1','2','4'])->select('rentEndDate','rent_status')->first();

        $mostNearDeliveryDate = Rents::where('books_id',$id)->whereIn('rent_status',['1','2'])->orderBy('rentEndDate','ASC')->first();

//        dd($mostNearDeliveryDate);

//        $allrents = Rents::where('books_id',$id)->orderby('rentEndDate','DESC')->get();

        if ($kitap==null){
            return back();
        }else{
            return view('frontend.book.index')
                ->with('kitapDetay', $kitap)
//                ->with('allrents', $allrents)
                ->with('tarafimcaRezerve', $isReservatedByMe)
                ->with('myrentdetails', $reservation)
                ->with('mostNearDeliveryDate', $mostNearDeliveryDate);
        }
    }

    public function bookRez($id){
        $kitap = Books::find($id);
        $myReservation =  Rents::where('books_id',$id)->where('users_id',Auth::id())->whereIn('rent_status',['1','2','4'])->exists();

        if ($myReservation){
            return response()->json('Bu kitap için rezervasyonunuz bulunuyor!');
        }

        if ($kitap->book_stok==0){
            return response()->json('Kitabın stok durumu uygun değil!');
        }else if($kitap->book_stok==1){
            $rentIstek = DB::table('rents')
                ->insert([
                    'users_id' => Auth::id(),
                    'books_id' => $id,
                    'rent_auth' => Auth::id(),
                    'rentStartDate' => now(),
                    'rentEndDate' => now()->addWeek(2),
                    'rent_status' => 1
                ]);

            $kitapKiralamaDurumuGuncelle = Books::where('id',$id)->update([
                'book_rentStatus' => 0
            ]);

            $kitap->decrement('book_stok',1);

            return response()->json('Rezervasyon işlemi başarılı!');
        }else{
            $rentIstek = DB::table('rents')
                ->insert([
                    'users_id' => Auth::id(),
                    'books_id' => $id,
                    'rent_auth' => Auth::id(),
                    'rentStartDate' => now(),
                    'rentEndDate' => now()->addWeek(2),
                    'rent_status' => 1
                ]);

            $kitap->decrement('book_stok',1);

            return response()->json('Rezervasyon işlemi başarılı!');
        }

        return response()->json('Rezervasyon işlemi başarısız!');
    }
}
