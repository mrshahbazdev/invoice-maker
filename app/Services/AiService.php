<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AiService
{
    protected string $provider;
    protected ?string $openaiKey;
    protected ?string $anthropicKey;

    public function __construct()
    {
        $this->provider = Setting::get('ai.default_provider', 'openai');
        $this->openaiKey = Setting::get('ai.openai_api_key');
        $this->anthropicKey = Setting::get('ai.anthropic_api_key');
    }

    public function generateText(string $prompt, ?string $imagePath = null): string
    {
        try {
            if ($this->provider === 'anthropic') {
                return $this->callAnthropic($prompt, $imagePath);
            }

            return $this->callOpenAi($prompt, $imagePath);
        } catch (Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function callOpenAi(string $prompt, ?string $imagePath = null): string
    {
        if (!$this->openaiKey) {
            throw new Exception("OpenAI API key is not configured.");
        }

        $messages = [];

        if ($imagePath && file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            $base64 = base64_encode(file_get_contents($imagePath));

            $messages[] = [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $prompt],
                    [
                        'type' => 'image_url',
                        'image_url' => [
                            'url' => "data:{$mimeType};base64,{$base64}"
                        ]
                    ]
                ]
            ];
        } else {
            $messages[] = [
                'role' => 'user',
                'content' => $prompt
            ];
        }

        $response = Http::timeout(60)->withToken($this->openaiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'temperature' => 0.7,
            ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content') ?? '';
        }

        throw new Exception("OpenAI API Error: " . $response->body());
    }

    protected function callAnthropic(string $prompt, ?string $imagePath = null): string
    {
        if (!$this->anthropicKey) {
            throw new Exception("Anthropic API key is not configured.");
        }

        $content = [];
        if ($imagePath && file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            $base64 = base64_encode(file_get_contents($imagePath));
            $content[] = [
                'type' => 'image',
                'source' => [
                    'type' => 'base64',
                    'media_type' => $mimeType,
                    'data' => $base64,
                ]
            ];
        }

        $content[] = [
            'type' => 'text',
            'text' => $prompt
        ];

        $response = Http::timeout(60)->withHeaders([
            'x-api-key' => $this->anthropicKey,
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
                    'model' => 'claude-3-haiku-20240307',
                    'max_tokens' => 1024,
                    'messages' => [
                        ['role' => 'user', 'content' => $content]
                    ]
                ]);

        if ($response->successful()) {
            return $response->json('content.0.text') ?? '';
        }

        throw new Exception("Anthropic API Error: " . $response->body());
    }
}
