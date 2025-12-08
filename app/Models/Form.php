<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'structure', 'response_limit'];


    protected $casts = [
        'structure' => 'array',
    ];

    public function responses() {
        return $this->hasMany(FormResponse::class);
    }
}
