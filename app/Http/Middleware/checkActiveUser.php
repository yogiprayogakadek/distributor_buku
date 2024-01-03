<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->is_active == false) {
            Auth::logout();
            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Akun anda di nonaktifkan, mohon menghubungi admin!',
                'title' => 'gagal login'
            ]);
        }
        return $next($request);
    }
}
