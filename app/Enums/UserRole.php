<?php

namespace App\Enums;

enum UserRole: string
{
    use EnumHelper;

    case ADMIN = 'admin';
    case USER = 'user';
}
