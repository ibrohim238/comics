<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Teamable
{
    public function teams(): MorphToMany;
}
