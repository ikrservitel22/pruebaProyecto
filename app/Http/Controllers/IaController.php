<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IaController extends Controller
{
    public function index()
    {
        return view('Usuarios/chatia');
    }

    // =========================
    // CHAT NORMAL
    // =========================
    public function chat(Request $request)
    {
        try {

            $response = Http::timeout(1000)->post(
                'http://proyecto-ia:8001/chat',
                [
                    'message' => $request->mensaje,
                    'historial' => $request->historial ?? []
                ]
            );

            return response()->json(
                $response->json()
            );

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =========================
    // AUDIO
    // =========================
    public function audio(Request $request)
    {
        try {

            if (!$request->hasFile('audio')) {

                return response()->json([
                    'error' => 'No se recibió audio'
                ], 400);
            }

            $audio = $request->file('audio');

            $response = Http::timeout(1200)
                ->attach(
                    'file',
                    file_get_contents($audio->getRealPath()),
                    $audio->getClientOriginalName()
                )
                ->post(
                    'http://proyecto-audio:8000/audio',
                    [
                        // 👇 IMPORTANTE
                        'historial' => json_encode(
                            $request->historial ?? []
                        )
                    ]
                );

            return response(
                $response->body(),
                $response->status()
            )->header(
                'Content-Type',
                'application/json'
            );

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}