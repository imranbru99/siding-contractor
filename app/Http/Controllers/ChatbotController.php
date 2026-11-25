<?php

namespace App\Http\Controllers;

use App\Services\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __invoke(Request $request, AiAssistantService $ai): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return response()->json([
            'reply' => $ai->chat($data['message'], 'public'),
        ]);
    }
}
