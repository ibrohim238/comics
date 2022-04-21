<?php

namespace App\Enums;

enum PermissionEnum: string
{
    use EnumTrait;

    case MANAGE_MANGA = 'manage manga';
    case MANAGE_COMMENT = 'manage comment';
    case MANAGE_USER = 'manage user';
    case MANAGE_TEAM = 'manage_team';
    case CREATE_TEAM = 'create_team';
    case VIEW_ADMIN_PANEL = 'view admin panel';
    case ASSIGN_MODERATOR = 'assign moderator';
    case ASSIGN_ADMIN = 'assign admin';
    case ASSIGN_EDITOR = 'assign edit';
}
