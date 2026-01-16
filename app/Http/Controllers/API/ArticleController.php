<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Mengambil daftar artikel dengan fitur Filter Kategori dan Pencarian
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi Query dasar (Hanya yang sudah dipublikasikan)
        $query = Article::with(['category', 'author'])->where('status', 'published');

        // 2. FITUR FILTER KATEGORI: (?category=slug)
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. FITUR SEARCH / PENCARIAN: (?q=keyword)
        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // 4. Eksekusi query dengan urutan terbaru (latest)
        $articles = $query->latest()->get();

        return response()->json($articles);
    }

    /**
     * Mengambil satu artikel secara detail berdasarkan Slug
     * Terintegrasi dengan relasi: category, author, dan tags
     */
    public function show($slug)
    {
        $article = Article::with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($article);
    }

    /**
     * Mengambil semua daftar kategori untuk menu filter di Frontend
     * Terintegrasi dengan hitungan jumlah artikel yang berstatus 'published' saja
     */
    public function categories()
    {
        // Mengambil kategori beserta hitungan otomatis jumlah artikel yang statusnya published
        $categories = Category::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->get();

        return response()->json($categories);
    }
}
