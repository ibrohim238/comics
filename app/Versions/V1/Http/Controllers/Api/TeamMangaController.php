<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Versions\V1\Repository\MangaRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class TeamMangaController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Team $team, Request $request): MangaCollection
    {
        $this->authorize('mangaViewAny', $team);

        $mangas = app(MangaRepository::class, [
            'manga' => $team->mangas()
        ])->paginate($request->get('count'));

        return new MangaCollection($mangas);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Team $team, Manga $manga): MangaResource
    {
        $this->authorize('mangaView', $team);

        return new MangaResource($manga);
    }
}
