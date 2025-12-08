<?php

namespace App\Enums;

enum ItemStatus: string{

    use ValueOf;
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';

}
