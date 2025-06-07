<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json(['message' => 'No categories found'], 404);
        }

        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category, 200);
    }
}
