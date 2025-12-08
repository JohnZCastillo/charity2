<?php

namespace App\Enums;

enum UserRole: string
{

    use ValueOf;

    case ADMIN = 'admin';
    case STAFF = 'staff';
}
