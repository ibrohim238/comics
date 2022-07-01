<?php

namespace App\Policies;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ChapterPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Chapter $chapter): bool
    {
        return true;
    }

    public function create(User $user, Manga $manga): bool
    {
        return
            $user->teams()
                ->whereHas('mangas', function (Builder $builder) use ($manga){
                        $builder->where('teamable_id', $manga->id);
                })->exists();
    }

    public function update(User $user, Chapter $chapter, Manga $manga): bool
    {
        return
            $user->teams()
                ->whereHas('mangas', function (Builder $builder) use ($manga) {
                    $builder->where('teamable_id', $manga->id);
                })->exists();
    }

    public function delete(User $user, Chapter $chapter, Manga $manga): bool
    {
        return
            $user->teams()
                ->whereHas('mangas', function (Builder $builder) use ($manga) {
                    $builder->where('teamable_id', $manga->id);
                })->exists();
    }
}
