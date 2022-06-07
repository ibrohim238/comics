<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Filterable
{
    public function filters(): MorphToMany;
}
