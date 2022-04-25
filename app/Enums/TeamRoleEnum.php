<?php

namespace App\Enums;

enum TeamRoleEnum: string
{
    case owner = 'owner';
    case moderator = 'moderator';

    /**
     * @return array<int, TeamPermissionEnum>
     */
    public function permissions(): array
    {
        return match ($this) {
            self::owner => TeamPermissionEnum::cases(),
            self::moderator => [
                TeamPermissionEnum::MANAGE_MANGA,
            ],
        };
    }
}
