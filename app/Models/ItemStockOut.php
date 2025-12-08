<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemStockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'note',
        'item_id',
        'donation_id',
    ];

    protected function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    protected function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

}
