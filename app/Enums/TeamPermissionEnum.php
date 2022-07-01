<?php

namespace App\Enums;

enum TeamPermissionEnum: string
{
    use EnumTrait;

    case MANAGE_TEAM = 'manage team';
    case MANAGE_MANGA = 'manage manga';
    case MANAGE_USER = 'manage user';
    case MANAGE_INVITATION = 'manage invitation';
    case ASSIGN_MODERATOR = 'assign moderator';
}
