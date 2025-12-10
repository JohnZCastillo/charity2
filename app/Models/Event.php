<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'image',
        'start',
        'end',
        'form_id'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(EventImage::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(EventImage::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

      public function getCanRegisterAttribute()
    {
        return isset($this->form) && Carbon::now()->lessThan($this->start);
    }
}
