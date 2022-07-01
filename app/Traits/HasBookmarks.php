<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasBookmarks
{
    public function bookmarkUsers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'bookmarkable', 'bookmarks');
    }
}
