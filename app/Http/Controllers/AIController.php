<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $apiKey = env('GROQ_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama3-8b-8192',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un asistente experto en mecánica automotriz para un taller. Ayudas a diagnosticar fallas, sugieres repuestos y das consejos técnicos profesionales.'],
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        return response()->json($response->json());
    }

    public function index()
    {
        return view('ai-chat');
    }
}
