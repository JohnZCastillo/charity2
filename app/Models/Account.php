<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    use HasFactory;


    protected $fillable = [
        'code',
        'name',
        'email',
        'mobile',
        'status',
        'type',
    ];

    protected $casts = [
        'type' => UserType::class,
        'status' => UserStatus::class
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

}
