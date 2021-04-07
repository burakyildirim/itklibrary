<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Libraries;
use App\Models\Rents;
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
    public function index()
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

        $data['rents'] = Rents::whereIn('books_id',$kitaplar)
            ->select('rents.*')
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
//        $libraries = Libraries::where('id', $id)->first();
//
//        $libraryAuthPersons = User::
//        where('role','3')
//            ->get();
//
//        return view('backend.libraries.edit')->with('libraries', $libraries)->with('libraryAuthPersons',$libraryAuthPersons);
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
//        dd($id);
//        $libraries = Libraries::where('id', $id)->update(
//            [
//                "libraries_name" => $request->libraries_name,
//                "libraries_phone" => $request->libraries_phone,
//                "libraries_address" => $request->libraries_address,
//                "libraries_auth" => $request->libraries_auth
//            ]);
//
//        if ($libraries) {
//            return back()->with("success", "Güncelleme başarılı!");
//        }
//
//        return back()->with("error", "Güncelleme başarısız!");
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
}
