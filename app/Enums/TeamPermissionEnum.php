<?php

namespace App\Enums;

enum TeamPermissionEnum: string
{
    case MANAGE_TEAM = 'manage team';
    case MANAGE_MANGA = 'manage manga';
    case ASSIGN_MODERATOR = 'assign moderator';
}
