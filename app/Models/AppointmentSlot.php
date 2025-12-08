<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppointmentSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'capacity',
        'type',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    protected $appends = [
        'test',
        'className', 'available',
    ];

    public function getClassNameAttribute()
    {
        return 'pointer';
    }

    public function getTestAttribute()
    {
        return $this->date->format('Y-m-d');
    }

    public function getAvailableAttribute()
    {
        return 0;
    }
}
