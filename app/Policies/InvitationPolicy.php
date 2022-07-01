<?php

namespace App\Policies;

use App\Enums\TeamPermissionEnum;
use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, User $currentUser): bool
    {
        return $currentUser->is($user);
    }

    public function accept(User $user, Invitation $invitation): bool
    {
        return $invitation->user()->is($user);
    }

    public function reject(User $user, Invitation $invitation): bool
    {
        return $invitation->user()->is($user);
    }
}
