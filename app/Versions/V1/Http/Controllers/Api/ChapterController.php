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
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Chapter::class);
    }

    public function index(Manga $manga)
    {
        $chapters = $manga->chapters()->get();

        return new ChapterCollection($chapters);
    }

    public function show(Manga $manga, Chapter $chapter): ChapterResource
    {
        return new ChapterResource($chapter->load('media', 'comments'));
    }

    /**
     * @throws UnknownProperties
     */
    public function store(ChapterRequest $request)
    {
        $chapter = (new ChapterService(new Chapter()))->save(ChapterDto::fromRequest($request));;

        return new ChapterResource($chapter);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(Chapter $chapter, ChapterRequest $request)
    {
        (new ChapterService($chapter))->save(ChapterDto::fromRequest($request));

        return new ChapterResource($chapter);
    }

    public function destroy(Chapter $chapter)
    {
        (new ChapterService($chapter))->delete();

        return response()->noContent();
    }
}
