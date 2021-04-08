<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Libraries;
use App\Models\Rents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function index(){
        if (Auth::user()->role == 1){
            $kitaplar = Books::select('id')->get();

            $authUserLibraries = Libraries::
                select('libraries.id as id','libraries_name',DB::raw('COUNT(*) as libraryBooksCount'))
                ->groupBy('libraries_name')
                ->with('books')
                ->get();
        }else{
            $authUserLibraries = Libraries::where('libraries_auth', Auth::id())
                ->select('id','libraries_name',DB::raw('COUNT(books.*) as libraryBooksCount'))
                ->with('books')
                ->get();

            $kitaplar = Books::
            whereIn('libraries_id', $authUserLibraries)
                ->orderBy('book_name', 'ASC')
                ->select('id')
                ->get();
        }

        $data['authUserLibraries'] = $authUserLibraries;

        // teslim tarihi yaklaşan kitaplar
        $data['rents'] = Rents::whereIn('books_id',$kitaplar)
            ->where('rent_status',2)
            ->where('rentEndDate','>',now())
            ->select('rents.*')
            ->orderby(DB::raw('ABS(DATEDIFF(rentEndDate, NOW()))'))
            ->with('user')
            ->with('book')
            ->Paginate(7);

        // teslim tarihi geçen kitaplar
        $data['rentsOverDate'] = Rents::whereIn('books_id',$kitaplar)
            ->where('rent_status',2)
            ->where('rentEndDate','<',now())
            ->select('rents.*')
            ->orderby(DB::raw('ABS(DATEDIFF(rentEndDate, NOW()))'))
            ->with('user')
            ->with('book')
            ->Paginate(7);

        // onay bekleyen kitaplar
        $data['rentsWaitingApprove'] = Rents::whereIn('books_id',$kitaplar)
            ->where('rent_status',1)
            ->select('rents.*')
            ->orderby(DB::raw('ABS(DATEDIFF(rentEndDate, NOW()))'))
            ->with('user')
            ->with('book')
            ->Paginate(7);


//        return view('backend.rents.index', compact('data'));

        return view('backend.default.index', compact('data'));
    }
}
