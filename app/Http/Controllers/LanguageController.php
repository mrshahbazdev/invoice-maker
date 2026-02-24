<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LanguageController
{
    public function switch($locale)
    {
        $enabledLanguages = \App\Models\Setting::get('site.enabled_languages', [
            'en' => 'English',
            'de' => 'Deutsch',
            'es' => 'Español',
            'fr' => 'Français',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ar' => 'العربية',
            'zh' => '中文',
            'ja' => '日本語',
            'ru' => 'Русский'
        ]);

        if (!array_key_exists($locale, $enabledLanguages)) {
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
