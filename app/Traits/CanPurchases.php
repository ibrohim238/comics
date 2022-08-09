<?php

namespace App\Traits;

use App\Models\Chapter;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanPurchases
{
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function access_chapter(Chapter $chapter): bool
    {
        return $this->purchases()
            ->where('purchasable_type', 'chapter')
            ->where('purchasable_id', $chapter->id)
            ->exists();
    }
}