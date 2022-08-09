<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Purchasable
{
    public function purchases(): MorphMany;
}