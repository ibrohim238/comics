<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Dto\ChapterDto;
use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\ChapterRequest;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use App\Versions\V1\Repositories\ChapterRepository;
use App\Versions\V1\Repositories\MangaRepository;
use App\Versions\V1\Services\ChapterService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource([Chapter::class, 'manga'], ['chapter', 'manga']);
    }

    public function index(Manga $manga, Request $request)
    {
        $chapters = app(MangaRepository::class, [
            'manga' => $manga
        ])->paginateChapter($request->get('count'));

        return new ChapterCollection($chapters);
    }

    public function show(Manga $manga, Chapter $chapter): ChapterResource
    {
        return new ChapterResource(
            app(ChapterRepository::class, [
                'chapter' => $chapter
            ])->load()->getChapter()
        );
    }

    public function store(Manga $manga, ChapterRequest $request): ChapterResource
    {
        $chapter = app(ChapterService::class)
            ->store(ChapterDto::fromRequest($request), $manga);

        return new ChapterResource($chapter);
    }

    public function update(Manga $manga, Chapter $chapter, ChapterRequest $request): ChapterResource
    {
        app(ChapterService::class, [
            'chapter' => $chapter
        ])->update(ChapterDto::fromRequest($request));

        return new ChapterResource($chapter);
    }

    public function destroy(Manga $manga, Chapter $chapter): Response
    {
        app(ChapterService::class, [
            'chapter' => $chapter
        ])->delete();

        return response()->noContent();
    }
}
