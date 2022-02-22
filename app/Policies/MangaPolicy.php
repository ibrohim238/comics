<?php

namespace App\Policies;

use App\Models\Manga;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MangaPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Manga $manga): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Manga $manga): bool
    {
        //
    }

    public function delete(User $user, Manga $manga): bool
    {
        //
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
