<?php

namespace App\Enums;

enum ExpenseType: string{

    use ValueOf;
    case DONATE = 'donate';
    case EXPENSE = 'expense';

}
