<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se existe um idioma salvo na sessão. Se não, usa o padrão (en).
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        } else {
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
