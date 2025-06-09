<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UnsplashController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json(['error' => 'No se especificó una consulta'], 400);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . config('services.unsplash.access_key'),
        ])->get('https://api.unsplash.com/search/photos', [
            'query' => $query,
            'per_page' => 20,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Error consultando Unsplash'], 500);
        }

        return response()->json($response->json());
    }
}
