<?php

namespace App\Enums;

enum UserType: string
{

    use ValueOf;

    case DONOR = 'donor';
    case RECIPIENT = 'recipient';
}
