<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!in_array($user->level->name, $levels)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
