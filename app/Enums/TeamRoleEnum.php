<?php

namespace App\Enums;

enum TeamRoleEnum: string
{
    case owner = 'owner';
    case editor = 'editor';

    /**
     * @return array<TeamPermissionEnum>
     */
    public function permissions(): array
    {
        return match ($this) {
            self::owner => TeamPermissionEnum::values(),
            self::editor => [
                TeamPermissionEnum::MANAGE_MANGA->value,
            ],
        };
    }
}
