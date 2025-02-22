<?php

namespace App\Core\Enum;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }
}
