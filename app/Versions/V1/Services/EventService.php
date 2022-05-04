<?php

namespace App\Versions\V1\Services;

use App\Enums\EventTypeEnum;
use App\Models\Eventable;
use App\Models\User;
use App\Versions\V1\Dto\EventDto;

class EventService
{
    public function create(Eventable $eventable, ?User $user, EventTypeEnum $type)
    {
        $eventable->events()
            ->create(EventDto::fromArray([
                'user_id' => $user->id,
                'type' => $type->value,
            ])->toArray());
    }
}
