<?php

namespace App\Enums;

enum UserStatus: string{

    use ValueOf;

    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
}
