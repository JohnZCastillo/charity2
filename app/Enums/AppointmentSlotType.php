<?php

namespace App\Enums;

enum AppointmentSlotType: string
{

    use ValueOf;

    case AM = 'am';
    case PM = 'pm';
}
