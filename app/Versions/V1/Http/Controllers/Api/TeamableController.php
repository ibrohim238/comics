<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Services\TeamableService;
use App\Versions\V1\Traits\IdentifiesModels;
use Illuminate\Auth\Access\AuthorizationException;

class TeamableController extends Controller
{
    use IdentifiesModels;

    /**
     * @throws AuthorizationException
     */
    public function attach(Team $team, string $model, int $id)
    {
        $this->authorize('attachTeamable', $team);

        $model = $this->identifyModel($model, $id);

        app(TeamableService::class, [$model, $team])->create();
    }

    /**
     * @throws AuthorizationException
     */
    public function detach(Team $team, string $model, int $id)
    {
        $this->authorize('detachTeamable', $team);

        $model = $this->identifyModel($model, $id);

        app(TeamableService::class, [$model, $team]);
    }
}

