<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'purpose',
        'receipt',
        'type',
        'account_id',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
