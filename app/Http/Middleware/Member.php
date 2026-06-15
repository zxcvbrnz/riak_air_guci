<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Member
{
    // middleware untuk mengecek apakah user sudah memiliki member  atau belum

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Contoh logika: cek apakah user memiliki status member, jika belum ada maka akan di redirect ke halaman input unique code
        if (!$request->user()->member) {
            return redirect()->route('input-unique-code');
        }
        return $next($request);
    }
}
