<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Libraries;
use App\Models\Rents;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 1){
                $kitaplar = Books::select('id')->get();
        }else{
            $authUserLibraries = Libraries::where('libraries_auth', Auth::id())
                ->select('id')
                ->get();

                $kitaplar = Books::
                whereIn('libraries_id', $authUserLibraries)
                    ->orderBy('book_name', 'ASC')
                    ->select('id')
                    ->get();
        }

        $quer = $request->q;

        $data['rents'] = Rents::
            whereIn('books_id',$kitaplar)
            ->whereHas('user', function($que) use ($quer){
                $que->where('name', 'LIKE', '%'.$quer.'%');
            })
            ->orWhereHas('book', function($que) use ($quer){
                $que->where('book_name', 'LIKE', '%'.$quer.'%');
            })
            ->select('rents.*')
            ->orderby('rent_status','ASC')
            ->with('user')
            ->with('book')
            ->Paginate(12);

        return view('backend.rents.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $libraryAuthPersons = User::
//        where('role','3')
//            ->orderBy('name','ASC')
//            ->get();
//        return view('backend.libraries.create', compact('libraryAuthPersons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'libraries_name' => 'required',
//            'libraries_auth' => 'required'
//        ]);
//
//        $library = Libraries::insert(
//            [
//                "libraries_name" => $request->libraries_name,
//                "libraries_phone" => $request->libraries_phone,
//                "libraries_address" => $request->libraries_address,
//                "libraries_img" => $request->libraries_img,
//                "libraries_auth" => $request->libraries_auth
//            ]
//        );
//
//        if ($library) {
//            return redirect(route('libraries.index'))->with('success', 'İşlem Başarılı');
//        }
//        return back()->with('error', 'İşlem Başarısız');
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
        $rent = Rents::where('id', $id)->with('book')->first();
//        dd($rent);

        if (!($rent->rent_status == 1 || $rent->rent_status== 2))
        {
            return view('backend.rents.index');
        }

        $users = User::
            orderBy('name','ASC')
            ->get();


        // kitap görünürlük durumlarını döndürür.
        $visStatus = Rents::RentStatusesEdit;

//        dd($visStatus);

        return view('backend.rents.edit')->with('users', $users)->with('rent',$rent)->with(compact('visStatus'));
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
        $rent = Rents::where('id', $id)->update(
            [
                "rentEndDate" => DateTime::createFromFormat('d.m.Y', $request->rentEndDate),
                "rent_status" => $request->rent_status,
                "updated_at" => now()
            ]);

        if ($rent) {
            return back()->with("success", "Güncelleme başarılı!");
        }


        return back()->with("error", "Güncelleme başarısız!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rent = Rents::find($id);
        $book = Books::find($rent->books_id);

        Books::where('id',$rent->books_id)->update([
            'book_rentStatus' => 1
        ]);

        $book->increment('book_stok',1);
        $rent->delete();

        return response()->json('Silme işlemi başarılı!');
    }

    public function check($id)
    {
        $rent = Rents::where('id',$id)->update([
            'rent_status' => 2,
            'updated_at' => now()
        ]);

        return response()->json('Kitap teslim işlemi başarılı!');
    }

    // Kütüphaneye kitabı teslim al.
    public function getbook($id)
    {
        $gelenRent = Rents::find($id);

        $guncelleme = Rents::where('id',$id)->update([
            'rent_status' => 3,
            'updated_at' => now()
        ]);

        $kitap = Books::find($gelenRent->books_id);

        if ($kitap->book_rentStatus==0) {
            Books::where('id',$kitap->id)->update([
                'book_rentStatus' => 1
            ]);
        }

        Books::find($gelenRent->books_id)->increment('book_stok',1);
        User::find($gelenRent->users_id)->increment('puan',50);

        return response()->json('Kitap teslim işlemi başarılı!');
    }
}
