<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Invited
{
    public function invitations(): MorphMany;
}
