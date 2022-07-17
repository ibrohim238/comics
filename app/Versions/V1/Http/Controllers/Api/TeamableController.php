<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\TeamableTypeEnum;
use App\Models\Team;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Services\TeamableService;
use App\Versions\V1\Traits\IdentifiesModels;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use function app;
use function response;

class TeamableController extends Controller
{
    public function attach(Team $team, TeamableTypeEnum $model, int $id): Response
    {
        app(TeamableService::class, [
            'team' => $team,
            'teamable' => $model = $model->identify($id),
        ])->attach();

        return response((['message' => Lang::get('teamable.attach')]));
    }

    public function detach(Team $team, TeamableTypeEnum $model, int $id): Response
    {
        app(TeamableService::class, [
            'team' => $team,
            'teamable' => $model->identify($id),
        ])->detach();

        return response(['message' => Lang::get('teamable.detach')]);
    }
}

