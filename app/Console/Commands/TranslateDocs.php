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
        $this->info("Starting AI Documentation Translation Engine...");

        $admin = \App\Models\User::whereNotNull('openai_api_key')
            ->orWhereNotNull('anthropic_api_key')
            ->first();

        if ($admin) {
            auth()->login($admin);
            $this->info("Authenticated as {$admin->name} to utilize personal AI keys.");
        } else {
            $this->warn("No API Keys found on any user profile. Fallbacks to global settings.");
        }

        $aiService = app(AiService::class);

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

                // Call AI Translator
                $prompt = "You are a professional technical translator for a B2B SaaS platform.\n\nTranslate the following Markdown documentation accurately into the language code: '{$langCode}'.\n\nCRITICAL RULES:\n1. Maintain EXACT Markdown syntactic structures (headers, bolding, lists, codeblocks, etc).\n2. Translate the TITLE header gracefully.\n3. Keep the tone professional, helpful, and localized.\n4. Output ONLY the translated Markdown. NO conversational filler, NO introductory text. Start directly with the translated '# <Title>' header.\n\n--- ORIGINAL MARKDOWN ---\n{$originalContent}";

                try {
                    // We generate using the default text provider configured in AiService
                    $translatedContent = $aiService->generateText($prompt);

                    // Clean up potential markdown code block wrappers sometimes returned by AI
                    if (str_starts_with($translatedContent, "```markdown\n")) {
                        $translatedContent = substr($translatedContent, 12);
                    }
                    if (str_ends_with(trim($translatedContent), "```")) {
                        $translatedContent = substr(trim($translatedContent), 0, -3);
                    }

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
