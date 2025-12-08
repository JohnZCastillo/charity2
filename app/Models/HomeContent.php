<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_title',
        'sub_title',
        'cta_button',
        'telephone',
        'contact_email',
        'address',
        'section_subtitle',
        'section_title',
        'team_title',
        'about_us',
        'about_title',
        'about_subtitle',
        'about_description',
        'mission_cards',
        'team_members',
        'section_cards', 
        'system_title',
        'system_logo',
        'additional_sections',
        'hero_images',
        'about_images',
        'qr_code_path'
    ];

    protected $casts = [
        'section_cards' => 'array',
        'team_members' => 'array',
        'mission_cards' => 'array',
        'additional_sections' => 'array',
        'about_images' => 'array',
        'hero_images'     => 'array',
    ];

}
