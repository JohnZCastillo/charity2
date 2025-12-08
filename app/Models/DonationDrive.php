<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonationDrive extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'goal',
        'image',
        'archived'
    ];

    protected  $casts = [
        'archived' => 'boolean'
    ];

    public function donations(): HasMany
    {
        return $this->hasMany(DonationDriveData::class);
    }

    public function getRaisedAttribute()
    {
        return $this->donations->sum('amount');

    }
}
