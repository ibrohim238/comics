<?php

namespace App\Versions\V1\Services;

use App\Models\Eventable;
use App\Models\User;

class EventService
{
    public function create(Eventable $eventable, ?User $user, string $type)
    {
        $eventable->events()
            ->create([
                'user_id' => $user->id ?? 0,
                'type' => $type,
            ]);
    }
}
