<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(private ChatbotService $chatbot) {}

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array|max:20',
        ]);

        $history = collect($request->input('history', []))
            ->filter(fn($item) => isset($item['role'], $item['text']))
            ->values()
            ->toArray();

        $result = $this->chatbot->chat($request->input('message'), $history);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => ['reply' => $result['message']],
        ]);
    }
}
