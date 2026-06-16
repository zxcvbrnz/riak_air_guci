<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrMember
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Coba jalankan middleware Admin terlebih dahulu
        try {
            return app(\App\Http\Middleware\Admin::class)->handle($request, function ($req) use ($next) {
                return $next($req);
            });
        } catch (\Throwable $e) {
            // 2. Jika Admin gagal/ditolak, coba jalankan middleware Member
            try {
                return app(\App\Http\Middleware\Member::class)->handle($request, function ($req) use ($next) {
                    return $next($req);
                });
            } catch (\Throwable $e) {
                // 3. Jika kedua middleware menolak, baru lempar error 403
                abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin atau Member.');
            }
        }
    }
}