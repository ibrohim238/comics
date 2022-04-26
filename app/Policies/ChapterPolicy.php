<?php

namespace App\Policies;

use App\Models\Chapter;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Chapter $chapter): bool
    {
        if (! $chapter->is_paid) {
            return false;
        }
        return true;
    }
}
