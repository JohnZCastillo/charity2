<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'item_id',
    ];

}
