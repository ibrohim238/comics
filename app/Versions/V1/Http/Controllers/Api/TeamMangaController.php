<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;

class TeamMangaController extends Controller
{
    public function index(Team $team)
    {
        $mangas = $team->mangas()->get();

        return new MangaCollection($mangas);
    }

    public function show(Team $team, Manga $manga)
    {
        return new MangaResource($manga);
    }
}
