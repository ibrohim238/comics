<?php

namespace App\Versions\V1\Services;

use App\Models\Team;
use App\Models\Invitation;
use App\Models\User;
use App\Versions\V1\Dto\TeamMemberDto;

class UserInviteService
{
    public function __construct(
        public Invitation $invitation
    ) {
    }

    public function accept(Invitation $invitation): void
    {
        $invitation->accept();
    }

    public function reject(Invitation $invitation): void
    {
        $invitation->reject();
    }
}
