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

    public function chat(Request $request)
    {
        $response = Http::timeout(120)->post(
            'http://proyecto-ia:8001/chat',
            [
                'message' => $request->mensaje,
                'historial' => $request->historial ?? []
            ]
        );

        if (!$response->successful()) {

            return response()->json([
                'respuesta' => 'Error conectando con IA'
            ], 500);
        }

        return response()->json(
            $response->json()
        );
    }
}