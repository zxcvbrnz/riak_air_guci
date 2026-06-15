<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Contoh logika: cek apakah user memiliki role user, jika tidak maka akan di redirect ke halaman home
        if ($request->user()->role !== 'user') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }
        return $next($request);
    }
}
