<?php

namespace App\Enums;

enum RolePermissionEnum: string
{
    use EnumTrait;

    case OWNER = 'owner';
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case EDITOR = 'editor';
    case USER = 'user';

    public function permissions(): array
    {
        return match ($this) {
            self::OWNER => [
                PermissionEnum::values()
            ],
            self::ADMIN => [
                PermissionEnum::VIEW_ADMIN_PANEL->value,
                PermissionEnum::MANAGE_MANGA->value,
                PermissionEnum::MANAGE_USER->value,
                PermissionEnum::MANAGE_COMMENT->value,
                PermissionEnum::ASSIGN_MODERATOR->value,
                PermissionEnum::MANAGE_TEAM->value,
                PermissionEnum::CREATE_TEAM->value,
                PermissionEnum::MANAGE_COUPON->value
            ],
            self::MODERATOR => [
                PermissionEnum::VIEW_ADMIN_PANEL->value,
                PermissionEnum::MANAGE_MANGA->value,
                PermissionEnum::MANAGE_COMMENT->value,
                PermissionEnum::MANAGE_USER->value,
                PermissionEnum::ASSIGN_EDITOR->value,
                PermissionEnum::CREATE_TEAM->value
            ],
            self::EDITOR => [
                PermissionEnum::CREATE_TEAM->value
            ],
            self::USER => [

            ]
        };
    }
}
