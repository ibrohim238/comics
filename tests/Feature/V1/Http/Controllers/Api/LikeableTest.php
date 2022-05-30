<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Versions\V1\Http\Resources\MediaCollection;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function route;

class LikeableTest extends TestCase
{
    use WithFaker;

}
