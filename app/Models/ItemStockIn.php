<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemStockIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'active_quantity',
        'expiration',
        'item_id',
    ];

    protected $casts = [
        'expiration' => 'date'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class,'item_id','id');
    }
}
