<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Models\Category;
use App\Models\Event;
use App\Models\LibraryInformation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. Route User (Bawaan Laravel Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 2. Route Kelompok Artikel
Route::prefix('articles')->group(function () {
    // Ambil semua artikel (Terbaru & Pilihan ditangani oleh filter di Controller atau Frontend)
    Route::get('/', [ArticleController::class, 'index']);

    // Ambil detail artikel berdasarkan SLUG
    Route::get('/{slug}', [ArticleController::class, 'show']);
});

// 3. Route Kategori
// Mengarahkan ke method 'categories' di ArticleController agar mendapat withCount
Route::get('/categories', [ArticleController::class, 'categories']);

// 4. Route Events (Acara Mendatang)
// Mengambil event yang statusnya 'published'
Route::get('/events', function () {
    return response()->json(Event::where('status', 'published')->latest()->get());
});

// 5. Route Library Information
// Mengambil informasi perpustakaan (seperti jam buka, kontak, dll)
Route::get('/library-info', function () {
    return response()->json(LibraryInformation::where('status', 'published')->get());
});
