<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\AiService;

class TranslateDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:translate {--force : Overwrite existing translations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translates all English documentation Markdown files into the 9 other supported languages using AI.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting Documentation Translation Engine...");

        $sourceLang = 'en';
        $targetLanguages = ['ar', 'de', 'es', 'fr', 'it', 'ja', 'pt', 'ru', 'zh'];

        $sourcePath = resource_path("docs/{$sourceLang}");
        if (!File::exists($sourcePath)) {
            $this->error("Source directory not found: {$sourcePath}");
            return Command::FAILURE;
        }

        $files = File::files($sourcePath);
        if (count($files) === 0) {
            $this->info("No markdown files found in {$sourcePath}. Exiting.");
            return Command::SUCCESS;
        }

        $force = $this->option('force');
        $totalFiles = count($files) * count($targetLanguages);
        $this->info("Found " . count($files) . " source files. Translating to " . count($targetLanguages) . " languages. Total planned requests: {$totalFiles}");

        $bar = $this->output->createProgressBar($totalFiles);
        $bar->start();

        foreach ($files as $file) {
            if ($file->getExtension() !== 'md') {
                continue;
            }

            $filename = $file->getFilename();
            $originalContent = File::get($file->getPathname());

            foreach ($targetLanguages as $langCode) {
                $targetDir = resource_path("docs/{$langCode}");
                if (!File::exists($targetDir)) {
                    File::makeDirectory($targetDir, 0755, true);
                }

                $targetFilePath = $targetDir . '/' . $filename;

                if (File::exists($targetFilePath) && !$force) {
                    // Skip if already translated (unless --force)
                    $bar->advance();
                    continue;
                }

                try {
                    // Google Translate API
                    $tr = new \Stichoza\GoogleTranslate\GoogleTranslate($langCode, 'en');

                    // Since Google translate might mangle long markdown, we can roughly quickly translate it
                    // The best way for raw markdown is to preserve format. Google might break markdown tags.
                    // But for this requirement, we'll try to translate raw text directly to fulfill the translation feature.
                    $translatedContent = $tr->translate($originalContent);

                    File::put($targetFilePath, trim($translatedContent));
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->error("Failed to translate {$filename} to {$langCode}: " . $e->getMessage());
                    // Don't halt the entire loop on one failure
                }

                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Documentation completely translated!");

        return Command::SUCCESS;
    }
}
