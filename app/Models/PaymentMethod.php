<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    
     protected $fillable = [
        'account_name',
        'bank_name',
        'account_number',
        'qr_code',
    ];
}
