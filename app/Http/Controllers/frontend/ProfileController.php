<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Rents;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(){
        $userProfile = Auth::user();

        return view('frontend.profile.Index')->with('userProfile',$userProfile);
    }

    public function reservations(){
        $data['myRents'] = Rents::
        where('users_id',Auth::id())
            ->select('rents.*')
            ->orderby('rentEndDate','DESC')
            ->with('user')
            ->with('book')
            ->Paginate(12);

        return view('frontend.profile.reservations', compact('data'));
    }
}
