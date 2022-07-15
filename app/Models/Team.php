<?php

namespace App\Models;

use App\Interfaces\Invited;
use App\Traits\HasInvitations;
use IAleroy\Teams\Models\Team as BaseTeam;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Team extends BaseTeam implements Invited
{
    use HasInvitations;

    public function mangas(): MorphToMany
    {
        return $this->morphedByMany(Manga::class, 'teamable');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }
}
