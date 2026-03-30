<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Ambil locale dari segmen pertama URL (id atau en)
        $locale = $request->segment(1);

        if (in_array($locale, ['id', 'en'])) {
            App::setLocale($locale);

            // INI KUNCINYA: Paksa URL generator menggunakan locale ini sebagai default
            URL::defaults(['locale' => $locale]);
        } else {
            // Jika tidak ada locale di URL, arahkan ke default (misal: id)
            return redirect()->to('/id' . $request->getRequestUri());
        }

        return $next($request);
    }
}