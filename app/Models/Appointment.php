<?php

namespace App\Models;

use App\Enums\AppointmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'type',
        'message',
        'start',
        'end',
        'date',
         'status',
    ];

    protected $casts = [
        'type' => AppointmentType::class,
    ];

    public function getTimeAttribute()
{
    return $this->start . ' - ' . $this->end;
}


}
