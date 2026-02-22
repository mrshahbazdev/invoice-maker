<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LanguageController
{
    public function switch($locale)
    {
        if (!in_array($locale, ['en', 'de', 'es', 'fr', 'it', 'pt', 'ar', 'zh', 'ja', 'ru'])) {
            abort(400);
        }

        session(['locale' => $locale]);
        App::setLocale($locale);

        if (Auth::check()) {
            Auth::user()->update(['language' => $locale]);
        }

        return redirect()->back();
    }
}
