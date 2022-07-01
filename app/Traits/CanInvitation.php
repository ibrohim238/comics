<?php

namespace App\Traits;

use App\Models\Invitation;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanInvitation
{
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }
}
