<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'banner',
        'description',
        'event_date',
        'location',
        'registration_link',
        'status',
        'user_id',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
