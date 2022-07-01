<?php

namespace App\Traits;

use App\Models\Manga;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait CanBookmarks
{
    public function mangas(): MorphToMany
    {
        return $this->morphedByMany(Manga::class, 'bookmarkable', 'bookmarks');
    }
}
