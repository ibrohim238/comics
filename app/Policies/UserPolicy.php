<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_USER->value);
    }

    public function view(User $user, User $targetUser): bool
    {
        return $user->is($targetUser) || $user->hasPermissionTo(PermissionEnum::MANAGE_USER->value);
    }

    public function update(User $user, User $targetUser): bool
    {
        return $user->is($targetUser) || $user->hasPermissionTo(PermissionEnum::MANAGE_USER->value);
    }

    public function delete(User $user, User $targetUser): bool
    {
        return  $user->is($targetUser) || $user->hasPermissionTo(PermissionEnum::MANAGE_USER->value);
    }

    public function restore(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_USER->value);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_USER->value);
    }
}
