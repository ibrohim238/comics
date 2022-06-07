<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Likeable
{
    public function rates(): MorphMany;

    public function likes(): MorphMany;

    public function likesCount(): int;

}
