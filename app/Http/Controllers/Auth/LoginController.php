<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToProvider(){
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(){
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // yalnızca @itk.k12.tr
//        if(explode("@", $user->email)[1] !== 'itk.k12.tr'){
//            return redirect()->to('/');
//        }

        // bu isimle kayıtlı bir kullanıcı var mı
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // giriş yap
            auth()->login($existingUser, true);
        } else {
            // yeni kullanıcı kaydı oluştur
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->google_id = $user->id;
            $newUser->avatar = $user->avatar;
            $newUser->role = 4;
            $newUser->password = Hash::make($user->id);

            $newUser->save();
            auth()->login($newUser, true);
        }

        return redirect()->to('/');
    }
}
