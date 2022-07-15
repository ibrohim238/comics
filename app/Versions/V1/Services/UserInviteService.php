<?php

namespace App\Versions\V1\Services;

use App\Models\Invitation;

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
