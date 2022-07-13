<?php

namespace App\Versions\V1\Services;

use App\Dto\EventDto;
use App\Enums\EventTypeEnum;
use App\Interfaces\Eventable;
use App\Models\User;

class EventService
{
    public function create(Eventable $eventable, ?User $user, EventTypeEnum $type)
    {
        $eventable->events()
            ->create(EventDto::fromArray([
                'user_id' => $user->id ?? null,
                'type' => $type->value,
            ])->toArray());
    }
}
