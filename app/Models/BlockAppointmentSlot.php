<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockAppointmentSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'date'
    ];

}
