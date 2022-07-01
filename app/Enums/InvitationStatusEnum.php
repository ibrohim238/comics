<?php

namespace App\Enums;

enum InvitationStatusEnum: string
{
    case REJECTED_STATUS = 'rejected';
    case ACCEPTED_STATUS = 'accepted';
}
