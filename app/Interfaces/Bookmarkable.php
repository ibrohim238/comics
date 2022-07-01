<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Bookmarkable
{
    public function bookmarkUsers(): MorphToMany;
}
