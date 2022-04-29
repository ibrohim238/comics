<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Filterable
{
    public function filters(): MorphToMany;
}
