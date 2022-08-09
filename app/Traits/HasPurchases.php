<?php

namespace App\Traits;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPurchases
{
    public function purchases(): MorphMany
    {
        return $this->morphMany(Purchase::class, 'purchasable');
    }
}