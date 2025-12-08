<?php

namespace App\Models;

use App\Enums\ItemStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
        'deleted',
        'item_category_id',
        'item_size_id',
        'item_gender_id',
    ];

    protected $casts = [
        'deleted' => 'boolean',
        'status' => ItemStatus::class
    ];

    protected $hidden = [
        'deleted',
    ];

    protected $appends = [
        'total_stock',
        'stock',
        'expired',
        'expiring',
    ];

    public function getTotalStockAttribute(): int
    {
        return $this->stockIns->sum('active_quantity') ?? 0;
    }

    public function getStockAttribute(): int
{
    return $this->stockIns
        ->filter(function ($stockIn) {
            return is_null($stockIn->expiration) || $stockIn->expiration > Carbon::now();
        })
        ->sum('active_quantity') ?? 0;
}


    public function getExpiredAttribute(): int
    {
        return $this->stockIns
            ->where('expiration', '<=', Carbon::now())
            ->sum('active_quantity') ?? 0;
    }

    public function getExpiringAttribute(): int
    {
        return $this->stocks
            ->whereBetween('expiration', [Carbon::now(), Carbon::now()->addDays(7)])
            ->sum('active_quantity') ?? 0;
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ItemStockIn::class);
    }

    public function stockIns(): HasMany
    {
        return $this->hasMany(ItemStockIn::class);
    }

    public function stockOuts(): HasMany
    {
        return $this->hasMany(ItemStockOut::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(ItemSize::class, 'item_size_id', 'id');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(ItemGender::class, 'item_gender_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id');
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function getInitQuantity(): int
    {
        return $this->stockIns->first()->value('quantity') ?? 0;
    }

      public function getNextExpirationDateAttribute(): ?string
    {
        $nextExpiration = $this->stockIns()
            ->where('expiration', '>', Carbon::now())
            ->orderBy('expiration', 'asc')
            ->value('expiration');

        return $nextExpiration 
            ? Carbon::parse($nextExpiration)->format('M d, Y') // e.g., Sep 14, 2025
            : null;
    }

    public function getExpirationStatusAttribute(): string
    {
        $nextExpiration = $this->next_expiration_date;

        if (!$nextExpiration) {
            return 'N/A';
        }

        $date = Carbon::parse($nextExpiration);

        if ($date->isPast()) {
            return 'Expired';
        }

        if ($date->between(Carbon::now(), Carbon::now()->addDays(7))) {
            return 'Expiring Soon';
        }

        return 'Valid';
    }

}