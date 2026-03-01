<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $endpoint = 'https://openrouter.ai/api/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key', '');
    }
    

    /**
     * Kirim pesan ke OpenRouter AI dan dapatkan respons.
     */
    public function chat(string $message, array $history = []): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'message' => 'Konfigurasi API chatbot belum diatur. Silakan hubungi administrator.',
            ];
        }

        $systemInstruction = "Kamu adalah asisten virtual King Gitar, sebuah toko gitar online premium. " .
            "Kamu HANYA boleh menjawab pertanyaan seputar gitar (akustik, elektrik, klasik, bass, ukulele), " .
            "aksesoris gitar, teknik bermain gitar, perawatan gitar, dan hal-hal yang berkaitan dengan konten website King Gitar. " .
            "Jika user bertanya di luar topik tersebut, tolak dengan sopan dan arahkan kembali ke topik gitar. " .
            "Jawab dalam bahasa Indonesia yang ramah dan informatif. Jawab dengan singkat dan jelas, tidak perlu terlalu panjang.";

        // Build messages array (OpenAI format)
        $messages = [
            ['role' => 'system', 'content' => $systemInstruction],
        ];

        foreach ($history as $item) {
            if (isset($item['role'], $item['text'])) {
                $role = $item['role'] === 'model' ? 'assistant' : 'user';
                $messages[] = ['role' => $role, 'content' => $item['text']];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        $payload = [
            'model' => 'liquid/lfm-2.5-1.2b-instruct:free',
            'messages'   => $messages,
            'max_tokens' => 512,
            'temperature' => 0.7,
        ];

        try {
            $http = Http::timeout(20)
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'HTTP-Referer'  => config('app.url', 'http://localhost'),
                    'X-Title'       => 'King Gitar AI',
                ]);

            if (config('app.env') === 'local') {
                $http = $http->withoutVerifying();
            }

            $response = $http->post($this->endpoint, $payload);

            if ($response->status() === 429) {
                Log::warning('OpenRouter rate limit hit', ['body' => $response->body()]);
                return [
                    'success' => false,
                    'message' => 'Layanan AI sedang sibuk. Silakan coba lagi beberapa saat. 🔄',
                ];
            }

            if ($response->status() === 401 || $response->status() === 403) {
                Log::error('OpenRouter auth error', ['status' => $response->status(), 'body' => $response->body()]);
                return [
                    'success' => false,
                    'message' => 'Konfigurasi API chatbot bermasalah. Silakan hubungi administrator. ⚠️',
                ];
            }

            if (!$response->successful()) {
                Log::error('OpenRouter API error', ['status' => $response->status(), 'body' => $response->body()]);
                return [
                    'success' => false,
                    'message' => 'Terjadi kesalahan pada layanan AI. Silakan coba lagi nanti. 😔',
                ];
            }

            $data = $response->json();
            $text = $data['choices'][0]['message']['content'] ?? null;

            if (!$text) {
                return [
                    'success' => false,
                    'message' => 'Maaf, saya tidak bisa memproses permintaan Anda saat ini. Silakan coba lagi. 🤔',
                ];
            }

            return [
                'success' => true,
                'message' => trim($text),
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('OpenRouter connection error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Tidak dapat terhubung ke layanan AI. Periksa koneksi internet dan coba lagi. 🌐',
            ];
        } catch (\Exception $e) {
            Log::error('OpenRouter unexpected error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi nanti. 😔',
            ];
        }
    }
}