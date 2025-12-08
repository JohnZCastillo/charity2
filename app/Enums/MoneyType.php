<?php

namespace App\Enums;

enum MoneyType: string{

    use ValueOf;
    case GCASH = 'gcash';
    case CASH = 'cash';
}
