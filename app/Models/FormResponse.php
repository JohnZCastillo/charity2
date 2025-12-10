<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormResponse extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'response', 'event_id'];

    protected $casts = [
        'response' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

     public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
