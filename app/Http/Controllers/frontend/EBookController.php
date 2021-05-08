<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\DigitalBooks;
use App\Models\EBooks;
use App\Models\Levels;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    public function index(Request $request)
    {
        $allDigitalBookBranches = Branches::orderBy('id', 'ASC')->get();
        $allClassLevels = Levels::orderBy('id', 'ASC')->get();

        $requestLevels = $request['seviye'];
        $requestBranches = $request['brans'];

//        dd($requestLevels);

        if ($request['seviye'] != null && $request['brans'] != null) {
            $allEbooks = DigitalBooks::with('levels')
                ->with('branches')
                ->orderBy('id', 'DESC')
                ->whereHas('levels', function ($l) use ($requestLevels) {
                    $l->whereIn('id', $requestLevels);
                })
                ->whereHas('branches', function ($b) use ($requestBranches) {
                    $b->whereIn('id', $requestBranches);
                })
                ->paginate(6);
        }elseif($request['seviye'] != null){
            $allEbooks = DigitalBooks::with('levels')
                ->with('branches')
                ->orderBy('id', 'DESC')
                ->whereHas('levels', function ($l) use ($requestLevels) {
                    $l->whereIn('id', $requestLevels);
                })->paginate(6);
        }elseif($request['brans'] != null){
            $allEbooks = DigitalBooks::with('levels')
                ->with('branches')
                ->orderBy('id', 'DESC')
                ->whereHas('branches', function ($b) use ($requestBranches) {
                    $b->whereIn('id', $requestBranches);
                })->paginate(6);
        }else{
            $allEbooks = DigitalBooks::orderBy('id', 'DESC')->paginate(6);
        }



        return view('frontend.ebook.index', compact('allEbooks', $allEbooks))
            ->with('allClassLevels', $allClassLevels)
            ->with('allDigitalBookBranches', $allDigitalBookBranches);
    }

    public function show($id)
    {
        $ebook = DigitalBooks::where('unique_key', $id)->first();
        return view('frontend.ebook.show')->with('ebookDetay', $ebook);
    }
}
