<?php

namespace App\Http\Controllers;

use App\Services\AiAssistantService;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'history' => 'nullable|array|max:10',
        ]);

        // تحويل سجل المحادثة للصيغة المطلوبة
        $history = collect($request->input('history', []))
            ->map(fn ($h) => [
                'role' => in_array($h['role'] ?? '', ['user', 'model']) ? $h['role'] : 'user',
                'parts' => [['text' => (string) ($h['text'] ?? '')]],
            ])
            ->values()
            ->all();

        $result = app(AiAssistantService::class)->chat($request->input('message'), $history);

        return response()->json($result);
    }

    public function status()
    {
        return response()->json(app(AiAssistantService::class)->status());
    }
}
