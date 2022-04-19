<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Chapter;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(User $user, Chapter $chapter): bool
    {
       //
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function update(User $user, Chapter $chapter): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function delete(User $user, Chapter $chapter): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function restore(User $user, Chapter $chapter): bool
    {
        //
    }

    public function forceDelete(User $user, Chapter $chapter): bool
    {
        //
    }
}
