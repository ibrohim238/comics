<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Services\TeamableService;
use App\Versions\V1\Traits\IdentifiesModels;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Lang;

class TeamableController extends Controller
{
    use IdentifiesModels;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @throws AuthorizationException
     */
    public function attach(Team $team, string $model, int $id)
    {
        $this->authorize('attach_teamable');

        $model = $this->identifyModel($model, $id);

        app(TeamableService::class, [
            'team' => $team,
            'teamable' => $model,
        ])->attach();

        return response(['message' => Lang::get('teamable.attach')]);
    }

    /**
     * @throws AuthorizationException
     */
    public function detach(Team $team, string $model, int $id)
    {
        $this->authorize('detach_teamable');

        $model = $this->identifyModel($model, $id);

        app(TeamableService::class, [
            'team' => $team,
            'teamable' => $model,
        ])->detach();

        return response(['message' => Lang::get('teamable.detach')]);
    }
}

