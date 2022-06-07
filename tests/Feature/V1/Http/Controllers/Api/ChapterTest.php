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

class ChapterTest extends TestCase
{
    use WithFaker;

    public function testIndexOk()
    {
        $manga = Manga::factory()->create();

        $chapters = Chapter::factory()->for($manga)->count(3)->create();

        $response = $this->getJson(route('chapter.index', $manga));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new ChapterCollection($chapters))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $chapter = Chapter::factory()->create();

        $response = $this->getJson(route('chapter.show', [$chapter->manga, $chapter]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterResource($chapter->load('media', 'manga.media', 'votes')))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $chapter = Chapter::factory()->create();

        $response = $this->getJson(route('chapter.show', [$chapter->manga, 'n']));

        $response->assertNotFound();
    }
}
