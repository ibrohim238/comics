<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasLikes
{
    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likeable');
    }
}
