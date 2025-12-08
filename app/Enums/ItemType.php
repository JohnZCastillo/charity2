<?php

namespace App\Enums;

enum ItemType: string{

    use ValueOf;
    case GENERAL = 'general';
    case GOODS = 'goods';
    case CLOTHES = 'clothes';
    case MEDICINE = 'medicine';
    case SUPPLIES = 'supplies';

}
