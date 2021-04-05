<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KutuphaneYonetici
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guest() && Auth::user()->role == 1 || !Auth::guest() && Auth::user()->role == 3) {
            return $next($request);
        }

        return redirect('/login');
    }
}
