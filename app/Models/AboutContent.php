<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',        // Section title
        'content',      // Main content (text or description)
        'items',        // JSON-encoded list-type items
        'image',        // Optional image
        'type',         // 'text', 'list', 'image', etc.
        'group',        // Section group/category (e.g. 'vision_mission')
        'order',        // Sorting index
    ];

    protected $casts = [
        'items' => 'array', // Automatically decode JSON as array
    ];
}
