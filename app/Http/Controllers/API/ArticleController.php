<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // Kebutuhan Fungsional: Hanya tampilkan yang statusnya 'published'
        $articles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->latest()
            ->get();

        return response()->json($articles);
    }

    public function show($slug)
    {
        $article = Article::with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($article);
    }

    public function categories()
    {
        return response()->json(Category::all());
    }
}
