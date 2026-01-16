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
        'category',
        'description',
        'event_date',
        'event_time',
        'location',
        'location_type',
        'registration_link',
        'spots_left',
        'status',
        'status_event',
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
