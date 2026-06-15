<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnMember
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Contoh logika: cek apakah user memiliki status member, jika sudah ada maka akan di redirect ke halaman home
        if ($request->user()->member) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
