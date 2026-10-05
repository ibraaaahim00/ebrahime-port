<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('portfolio.locales', ['en', 'ar']);
        $locale = $request->session()->get('locale', config('portfolio.default_locale', 'en'));

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = config('portfolio.default_locale', 'en');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
