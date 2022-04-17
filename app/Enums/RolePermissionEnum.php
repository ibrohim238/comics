<?php

namespace App\Enums;

enum RolePermissionEnum: string
{
    use EnumTrait;

    case OWNER = 'owner';
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';

    public function permissions(): array
    {
        return match ($this) {
            self::OWNER => [
                PermissionEnum::VIEW_ADMIN_PANEL,
                PermissionEnum::MANAGE_MANGA,
                PermissionEnum::MANAGE_USER,
                PermissionEnum::MANAGE_COMMENT,
                PermissionEnum::ASSIGN_MODERATOR,
                PermissionEnum::ASSIGN_ADMIN,
            ],
            self::ADMIN => [
                PermissionEnum::VIEW_ADMIN_PANEL,
                PermissionEnum::MANAGE_MANGA,
                PermissionEnum::MANAGE_USER,
                PermissionEnum::MANAGE_COMMENT,
                PermissionEnum::ASSIGN_MODERATOR,
            ],
            self::MODERATOR => [
                PermissionEnum::VIEW_ADMIN_PANEL,
                PermissionEnum::MANAGE_MANGA,
                PermissionEnum::MANAGE_COMMENT,
                PermissionEnum::MANAGE_USER,
            ],
            self::USER => [

            ]
        };
    }
}
