<?php

namespace App\Models;

use App\Enums\MoneyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationDriveData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'from',
        'amount',
        'donation_drive_id',
        'confirmed',
        'receipt',
        'email',
        'type',
        'reference'
    ];

    protected $casts = [
        'type' => MoneyType::class
    ];

    public function donationDrive(): BelongsTo
    {
        return $this->belongsTo(DonationDrive::class);
    }
}
