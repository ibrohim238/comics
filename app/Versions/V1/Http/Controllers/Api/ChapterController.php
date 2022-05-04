<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Chapter::class);
    }

    public function index(Manga $manga, Request $request)
    {
        $chapters = QueryBuilder::for($manga->chapters())
            ->allowedFilters(['team_id'])
            ->defaultSorts('-volume', '-number')
            ->allowedSorts('volume', 'number')
            ->paginate($request->get('count'));

        return new ChapterCollection($chapters);
    }

    public function show(Manga $manga, Chapter $chapter): ChapterResource
    {
        return new ChapterResource($chapter->load('media', 'manga.media'));
    }
}
