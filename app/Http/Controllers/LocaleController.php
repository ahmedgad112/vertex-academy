<?php

namespace App\Http\Controllers;

use App\Support\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request, string $locale): RedirectResponse
    {
        abort_unless(Locale::isSupported($locale), 404);

        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        return back();
    }
}
