<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\ChapterIndexRequest;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use Illuminate\Auth\Access\AuthorizationException;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Chapter::class);
    }

    public function index(Manga $manga, ChapterIndexRequest $request)
    {
        $chapters = $manga->chapters()->where('team_id', $request->validated('team_id'))->get();

        return new ChapterCollection($chapters);
    }

    public function show(Manga $manga, Chapter $chapter): ChapterResource
    {
        return new ChapterResource($chapter->load('media'));
    }
}
