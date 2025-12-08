<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'response'];

    protected $casts = [
        'response' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
