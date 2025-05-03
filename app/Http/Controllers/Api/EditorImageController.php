<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorImageController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $url = Storage::url($path);

            return response()->json([
                'path' => $path,
                'url' => asset($url),
            ], 200);
        }

        return response()->json(['message' => 'No file selected'], 400);
    }
}
