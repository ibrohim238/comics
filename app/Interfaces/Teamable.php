<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Teamable
{
    public function teams(): MorphToMany;
}
