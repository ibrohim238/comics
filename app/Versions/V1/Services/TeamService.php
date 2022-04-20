<?php

namespace App\Versions\V1\Services;

use App\Models\Team\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamDto;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TeamService
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function save(Team $team, TeamDto $dto): Team
    {
        $team = $team->fill($dto->toArray());
        $team->addMediaFromRequest('image')->toMediaCollection();

        return $team;
    }

    public function delete(Team $team)
    {
        $team->clearMediaCollection();
        $team->delete();
    }
}
