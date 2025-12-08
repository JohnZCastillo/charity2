<?php

namespace App\Enums;

enum AppointmentType: string
{

    use ValueOf;
    case MEETING = 'meeting';
    case VISIT = 'visit';
    case ASKING_FOR_HELP = 'asking for help';
    case DONATION = 'donation';
}
