<?php

namespace App\Enums;

enum ReportType: string
{

    use ValueOf;

    case RECIPIENT = 'Recipient';
    case DONOR = 'Donor';
    case CASH = 'Cash';

}