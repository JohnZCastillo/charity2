<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'recipient_id',
        'item_id',
        'quantity',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
