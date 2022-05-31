<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Likeable
{
    public function likes(): MorphToMany;
}
