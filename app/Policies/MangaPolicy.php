<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Manga;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MangaPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function update(User $user, Manga $manga): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function delete(User $user, Manga $manga): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function restore(User $user, Manga $manga): bool
    {
        //
    }

    public function forceDelete(User $user, Manga $manga): bool
    {
        //
    }
}
