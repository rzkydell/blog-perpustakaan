<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;

// Route testing default Sanctum (boleh dipertahankan atau dihapus kalau tidak perlu)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route publik untuk artikel & kategori (tidak perlu auth dulu)
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/categories', [ArticleController::class, 'categories']);

// Alternatif: lebih rapi pakai group + prefix (opsional tapi direkomendasikan)
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);       // → /api/articles
    Route::get('/{slug}', [ArticleController::class, 'show']); // → /api/articles/{slug}
});

Route::get('/categories', [ArticleController::class, 'categories']); // → /api/categories

// Jika nanti butuh route yang **protected** (misal create/update artikel dari frontend admin):
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/articles', [ArticleController::class, 'store']);
//     Route::put('/articles/{id}', [ArticleController::class, 'update']);
//     // dst...
// });