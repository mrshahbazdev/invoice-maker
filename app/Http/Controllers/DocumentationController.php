<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DocumentationController
{
    /**
     * Map of language codes to their human-readable names
     */
    protected $supportedLanguages = [
        'en' => 'English',
        'ar' => 'العربية',
        'de' => 'Deutsch',
        'es' => 'Español',
        'fr' => 'Français',
        'it' => 'Italiano',
        'ja' => '日本語',
        'pt' => 'Português',
        'ru' => 'Русский',
        'zh' => '中文',
    ];

    /**
     * Logical step-by-step ordering of the documentation guide.
     */
    protected $articleOrder = [
        'getting-started',
        'business-profile',
        'team-management',
        'products-inventory',
        'client-management',
        'estimates-quotes',
        'invoicing-engine',
        'expense-management',
        'accounting-cashbook',
        'client-portal-tickets',
        'custom-templates',
    ];

    /**
     * Display a list of all documentation articles in the given language.
     * Uses English as a fallback if the language isn't present.
     */
    public function index($lang = 'en')
    {
        if (!array_key_exists($lang, $this->supportedLanguages)) {
            abort(404);
        }

        app()->setLocale($lang);

        $docsPath = resource_path("docs/{$lang}");
        if (!File::exists($docsPath)) {
            // Fallback to English if the translation folder doesn't exist yet
            $lang = 'en';
            app()->setLocale($lang);
            $docsPath = resource_path("docs/en");
        }

        $files = File::files($docsPath);
        $articles = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'md') {
                $slug = $file->getFilenameWithoutExtension();
                $content = File::get($file->getPathname());

                // Extract Title (First # Header)
                preg_match('/^#\s+(.*)$/m', $content, $matches);
                $title = $matches[1] ?? Str::title(str_replace('-', ' ', $slug));

                // Extract Description (First non-header paragraph)
                $description = '';
                $lines = explode("\n", $content);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line !== '' && !str_starts_with($line, '#') && !str_starts_with($line, '-')) {
                        $description = Str::limit(strip_tags($line), 120);
                        break;
                    }
                }

                $articles[] = [
                    'slug' => $slug,
                    'title' => $title,
                    'description' => $description,
                ];
            }
        }

        // Sort dynamically based on our guide array
        usort($articles, function ($a, $b) {
            $posA = array_search($a['slug'], $this->articleOrder);
            $posB = array_search($b['slug'], $this->articleOrder);
            $posA = $posA !== false ? $posA : 999;
            $posB = $posB !== false ? $posB : 999;
            return $posA <=> $posB;
        });

        return view('docs.index', [
            'articles' => $articles,
            'currentLang' => $lang,
            'supportedLanguages' => $this->supportedLanguages,
        ]);
    }

    /**
     * Display a specific documentation article.
     */
    public function show($lang, $slug)
    {
        if (!array_key_exists($lang, $this->supportedLanguages)) {
            abort(404);
        }

        app()->setLocale($lang);

        $filePath = resource_path("docs/{$lang}/{$slug}.md");

        if (!File::exists($filePath)) {
            // Check if it exists in English as a fallback
            $fallbackPath = resource_path("docs/en/{$slug}.md");
            if (File::exists($fallbackPath)) {
                $filePath = $fallbackPath;
                $lang = 'en'; // Indicate we are showing the fallback
                app()->setLocale($lang);
            } else {
                abort(404);
            }
        }

        $content = File::get($filePath);

        // SEO Extraction
        preg_match('/^#\s+(.*)$/m', $content, $matches);
        $title = $matches[1] ?? Str::title(str_replace('-', ' ', $slug));

        $description = '';
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '' && !str_starts_with($line, '#') && !str_starts_with($line, '-')) {
                $description = Str::limit(strip_tags($line), 150);
                break;
            }
        }

        // Convert MD to HTML (Laravel 9+ uses Str::markdown())
        $htmlContent = Str::markdown($content);

        // Get sidebar articles
        $docsPath = resource_path("docs/{$lang}");
        $sidebarArticles = [];
        if (File::exists($docsPath)) {
            $files = File::files($docsPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'md') {
                    $itemSlug = $file->getFilenameWithoutExtension();
                    $itemContent = File::get($file->getPathname());
                    preg_match('/^#\s+(.*)$/m', $itemContent, $m);
                    $itemTitle = $m[1] ?? Str::title(str_replace('-', ' ', $itemSlug));

                    $sidebarArticles[] = [
                        'slug' => $itemSlug,
                        'title' => $itemTitle,
                        'isActive' => $itemSlug === $slug,
                    ];
                }
            }
        }

        // Sort dynamically based on our guide array
        usort($sidebarArticles, function ($a, $b) {
            $posA = array_search($a['slug'], $this->articleOrder);
            $posB = array_search($b['slug'], $this->articleOrder);
            $posA = $posA !== false ? $posA : 999;
            $posB = $posB !== false ? $posB : 999;
            return $posA <=> $posB;
        });

        return view('docs.show', [
            'htmlContent' => $htmlContent,
            'title' => $title,
            'description' => $description,
            'currentLang' => $lang,
            'supportedLanguages' => $this->supportedLanguages,
            'sidebarArticles' => $sidebarArticles,
            'slug' => $slug,
        ]);
    }
}
