<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function google(){
        // google oauth'a isteği gönderiyorum.
        return Socialite::driver('google')->redirect();
    }

    public function googleRedirect(){
        // google dan gelen oauth tepkisini sitede login session yaratmak için kullanıyorum.

        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // sadece itk.k12.tr mail adresiyle gelen kayıtları kabul ediyorum.
        if(explode("@", $user->email)[1] !== 'itk.k12.tr'){
            return redirect()->to('/');
        }

        // böyle bir kullanıcı varsa login page geri yönlendiriyorum.
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // eğer böyle bir kullanıcı varsa login ettiriyorum.
            auth()->login($existingUser, true);
        } else {
            // yoksa yeni bir kullanıcı kaydı oluşturuyorum.
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->google_id;
            $newUser->avatar          = $user->avatar;
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/');
    }
}
