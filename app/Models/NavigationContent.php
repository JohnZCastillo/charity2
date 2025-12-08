<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class NavigationContent extends Model
{
    /** @use HasFactory<\Database\Factories\NavigationContentFactory> */
    use HasFactory;

    protected $casts = [
     'socials' => 'array',
    ];

    protected $fillable = [
       'socials',
        'email',
        'mobile',
    ];

     protected function socials(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
        );
    }

}
