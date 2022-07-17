<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Versions\V1\Dto\ChapterDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\ChapterRequest;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use App\Versions\V1\Repositories\ChapterRepository;
use App\Versions\V1\Services\ChapterService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function app;
use function response;

class ChapterController extends Controller
{
    public function index(Request $request): ChapterCollection
    {
        $this->authorize('viewAny', Chapter::class);

        $chapters = app(ChapterRepository::class)
            ->paginate($request->get('count'));

        return new ChapterCollection($chapters);
    }

    public function show(Chapter $chapter): ChapterResource
    {
        $this->authorize('view', $chapter);

        return new ChapterResource(
            app(ChapterRepository::class, [
                'chapter' => $chapter
            ])->load()->getChapter()
        );
    }

    public function store(
        ChapterRequest $request
    ): ChapterResource
    {
        $this->authorize('create', [Chapter::class, $request->team_id]);

        $chapter = app(ChapterService::class)
            ->store(ChapterDto::fromRequest($request));

        return new ChapterResource($chapter);
    }

    public function update(
        Chapter $chapter,
        ChapterRequest $request
    ): ChapterResource
    {
        $this->authorize('update', $chapter);

        app(ChapterService::class, [
            'chapter' => $chapter
        ])->update(ChapterDto::fromRequest($request));

        return new ChapterResource($chapter);
    }

    public function destroy(
        Chapter $chapter
    ): Response
    {
        $this->authorize('delete', $chapter);

        app(ChapterService::class, [
            'chapter' => $chapter
        ])->delete();

        return response()->noContent();
    }
}
