<?php

namespace App\Enums;

enum AppointmentType: string
{

    use ValueOf;
    case MEETING = 'meeting';
    case VISIT = 'visitation for children';
    case ASKING_FOR_HELP = 'asking for help';
    case DONATION = 'donation';
    case OTHERS = 'others';
}
