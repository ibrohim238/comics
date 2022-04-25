<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\ChapterIndexRequest;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use Illuminate\Auth\Access\AuthorizationException;

class ChapterController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Manga $manga, ChapterIndexRequest $request)
    {
        $this->authorize('viewAny');

        $chapters = $manga->chapters()->where('team_id', $request->validated('team_id'))->get();

        return new ChapterCollection($chapters);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Manga $manga, int $chapterOrder): ChapterResource
    {
        $chapter = $manga->chapters()->where('order_column', $chapterOrder)->firstOrFail();

        $this->authorize('view', $chapter);

        return new ChapterResource($chapter->load('media'));
    }
}
