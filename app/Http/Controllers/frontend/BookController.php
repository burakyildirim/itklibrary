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
        //->where('book_slug',$slug)
        $kitap = Books::where('book_slug','=',$slug)->where('id',$id)->where('book_visStatus','=','1')
            ->with('library')
            ->first();

        if ($kitap==null) return back();

        $isReservatedByMe = Rents::where('books_id',$kitap->id)->where('users_id',Auth::id())->whereIn('rent_status',['1','2','4'])->exists();

        $reservation =  Rents::where('books_id',$kitap->id)->where('users_id',Auth::id())->whereIn('rent_status',['1','2','4'])->select('rentEndDate','rent_status')->first();

        $mostNearDeliveryDate = Rents::where('books_id',$kitap->id)->whereIn('rent_status',['1','2'])->orderBy('rentEndDate','ASC')->first();

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

    public function bookRez($id, $slug=null){
        $kitap = Books::where('id',$id)->where('book_slug',$slug)->first();
        $myReservation =  Rents::where('books_id',$id)->where('users_id',Auth::id())->whereIn('rent_status',['1','2','4'])->exists();
        $myReservationCount = Rents::where('users_id',Auth::id())->whereIn('rent_status',['1','2','4'])->count();

        if ($myReservation){
            $baslik = 'Rezervasyon işlemi gerçekleştirilemedi! :(';
            $metin = '<p class="text-danger">Bu kitap için zaten rezervasyonunuz bulunuyor! Kitabı teslim etmeden aynı kitap için rezervasyon oluşturamazsınız.</p>';
            return response()->json([
                'baslik' => $baslik,
                'metin' => $metin,
            ]);
        }

        if ($myReservationCount > 2){
            $baslik = 'Rezervasyon işlemi gerçekleştirilemedi! :(';
            $metin = '<p class="text-danger">Kütüphaneden aynı anda en fazla 3 kitap ödünç alabilirsiniz(ya da rezervasyon isteğinde bulunabilirsiniz). Yeni rezervasyon isteğinde bulunmadan önce bir kitabınızı teslim etmelisiniz.</p>';
            return response()->json([
                'baslik' => $baslik,
                'metin' => $metin,
                ]);
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

            $baslik = 'Rezervasyon işlemi başarılı! :)';
            $metin = '<p class="text-success">Rezervasyon isteğiniz başarıyla oluşturuldu. Şimdi sıra kitabın bulunduğu kütüphanenin görevlisi ile iletişime geçip kitabınızı teslim almanızda.<br><br> Keyifli okumalar!</p>';
            return response()->json([
                'baslik' => $baslik,
                'metin' => $metin,
            ]);
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

            $baslik = 'Rezervasyon işlemi başarılı! :)';
            $metin = '<p class="text-success">Rezervasyon isteğiniz başarıyla oluşturuldu. Şimdi sıra kitabın bulunduğu kütüphanenin görevlisi ile iletişime geçip kitabınızı teslim almanızda.<br><br> Keyifli okumalar!</p>';
            return response()->json([
                'baslik' => $baslik,
                'metin' => $metin,
            ]);
        }

        return response()->json('Rezervasyon işlemi başarısız!');
    }
}
