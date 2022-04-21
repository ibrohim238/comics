<?php

namespace App\Enums;

enum TeamRolePermissionEnum: string
{
    case owner = 'owner';
    case moderator = 'moderator';

    public function permissions(): array
    {
        return match ($this) {
            self::owner => [
                TeamPermissionEnum::MANAGE_TEAM,
                TeamPermissionEnum::ASSIGN_MODERATOR,
                TeamPermissionEnum::MANAGE_MANGA
            ],
            self::moderator => [
                TeamPermissionEnum::MANAGE_MANGA
            ]
        };
    }
}
