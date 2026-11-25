<?php

namespace App\Http\Middleware;

use App\Support\Locale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = config('app.locale');

        if ($request->hasSession()) {
            $sessionLocale = $request->session()->get('locale', $locale);
            $locale = is_string($sessionLocale) ? $sessionLocale : $locale;
        }

        if (! Locale::isSupported($locale)) {
            $locale = Locale::ENGLISH;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
