<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'banner',
        'pdf_file',
        'pdf_url',
        'status',
        'published_at',
        'category_id',
        'user_id',
    ];    

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi: artikel dimiliki oleh satu user (penulis)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: artikel memiliki satu kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: artikel memiliki banyak tag
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
