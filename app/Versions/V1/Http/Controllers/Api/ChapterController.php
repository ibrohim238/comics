<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Dto\ChapterDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\ChapterRequest;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use App\Versions\V1\Services\ChapterService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource([Chapter::class, 'manga'], ['chapter', 'manga']);
    }

    public function index(Manga $manga, Request $request)
    {
        $chapters = QueryBuilder::for($manga->chapters())
            ->defaultSorts('-volume', '-number')
            ->allowedSorts('volume', 'number')
            ->paginate($request->get('count'));

        return new ChapterCollection($chapters);
    }

    public function show(Manga $manga, Chapter $chapter): ChapterResource
    {
        return new ChapterResource($chapter->load('manga.media'));
    }

    public function store(Manga $manga, ChapterRequest $request)
    {
        $chapter = app(ChapterService::class)
            ->store(ChapterDto::fromRequest($request), $manga);

        return new ChapterResource($chapter);
    }

    public function update(Manga $manga, Chapter $chapter, ChapterRequest $request)
    {
        app(ChapterService::class, [
            'chapter' => $chapter
        ])->update(ChapterDto::fromRequest($request));

        return new ChapterResource($chapter);
    }

    public function destroy(Manga $manga, Chapter $chapter)
    {
        app(ChapterService::class, [
            'chapter' => $chapter
        ])->delete();

        return response()->noContent();
    }
}
