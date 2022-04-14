<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\ChapterResource;
use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function __invoke(Manga $manga, Chapter $chapter)
    {
        return new ChapterResource($chapter);
    }
}
