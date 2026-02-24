<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class Languages extends Component
{
    public $enabledLanguages = [];
    public $availableLocales = [
        'en' => 'English',
        'de' => 'Deutsch',
        'es' => 'Español',
        'fr' => 'Français',
        'it' => 'Italiano',
        'pt' => 'Português',
        'ar' => 'العربية',
        'zh' => '中文',
        'ja' => '日本語',
        'ru' => 'Русский',
        'nl' => 'Nederlands',
        'tr' => 'Türkçe',
        'pl' => 'Polski',
    ];

    public $editingLocale = null;
    public $translations = [];
    public $baseTranslations = [];
    public $search = '';

    public function mount()
    {
        $defaultLanguages = [
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
        ];

        $this->enabledLanguages = \App\Models\Setting::get('site.enabled_languages', $defaultLanguages);
        $this->loadBaseTranslations();
    }

    public function toggleLanguage($code, $name)
    {
        if ($code === 'en')
            return; // Cannot disable base language

        if (isset($this->enabledLanguages[$code])) {
            unset($this->enabledLanguages[$code]);
            if ($this->editingLocale === $code) {
                $this->editingLocale = null;
            }
        } else {
            $this->enabledLanguages[$code] = $name;
            $path = base_path("lang/{$code}.json");
            if (!\Illuminate\Support\Facades\File::exists($path)) {
                \Illuminate\Support\Facades\File::put($path, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }

        \App\Models\Setting::set('site.enabled_languages', $this->enabledLanguages, 'json');
        session()->flash('message', 'Languages updated successfully.');
    }

    protected function loadBaseTranslations()
    {
        $path = base_path('lang/en.json');
        if (\Illuminate\Support\Facades\File::exists($path)) {
            $this->baseTranslations = json_decode(\Illuminate\Support\Facades\File::get($path), true) ?? [];
        }
    }

    public function editTranslations($code)
    {
        $this->editingLocale = $code;
        $this->search = '';

        $path = base_path("lang/{$code}.json");
        $currentTranslations = [];
        if (\Illuminate\Support\Facades\File::exists($path)) {
            $currentTranslations = json_decode(\Illuminate\Support\Facades\File::get($path), true) ?? [];
        }

        $this->translations = [];
        foreach ($this->baseTranslations as $key => $baseValue) {
            $this->translations[$key] = $currentTranslations[$key] ?? '';
        }
    }

    public function saveTranslations()
    {
        if (!$this->editingLocale)
            return;

        $path = base_path("lang/{$this->editingLocale}.json");

        $toSave = [];
        foreach ($this->translations as $key => $value) {
            if (trim($value) !== '') {
                $toSave[$key] = $value;
            }
        }

        \Illuminate\Support\Facades\File::put($path, json_encode($toSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        session()->flash('message', 'Translations saved successfully.');
    }

    #[\Livewire\Attributes\Layout('layouts.admin', ['title' => 'Language & Localization'])]
    public function render()
    {
        $filteredBase = $this->baseTranslations;
        if ($this->search) {
            $filteredBase = array_filter($this->baseTranslations, function ($key) {
                return stripos($key, $this->search) !== false;
            }, ARRAY_FILTER_USE_KEY);
        }

        return view('livewire.admin.settings.languages', [
            'filteredKeys' => array_keys($filteredBase)
        ]);
    }
}
