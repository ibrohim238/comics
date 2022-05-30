<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Likeable
{
    public function rates(): MorphMany;

    public function likesDislikesCount(): int;

    public function likesCount(): int;

    public function dislikesCount(): int;
}
