<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function route;

class ChapterTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->team = Team::factory()->create();
        $this->manga = Manga::factory()->create();
        $this->chapter = Chapter::factory()->for($this->manga)->create();
        $this->user = User::factory()->create();

        $this->user->addToTeam($this->team,'owner');

        $this->team->mangas()->attach($this->manga->id);
    }

    public function testIndexOk()
    {
        $manga = Manga::factory()->create();
        $chapters = Chapter::factory()->for($manga)->count(3)->create();

        $response = $this->getJson(route('manga.chapter.index', $manga));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new ChapterCollection($chapters))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $response = $this->getJson(route('manga.chapter.show', [$this->manga, $this->chapter]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterResource($this->chapter->load('manga.media')))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('manga.chapter.show', [$this->manga, 'n']));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('manga.chapter.store', [$this->manga]), [
            'volume' => $this->faker->numberBetween(1, 5),
            'number' => $this->faker->numberBetween(0, 1000),
            'name' => $this->faker->name
        ]);

        $response->assertCreated();
    }

    public function testUpdateOk()
    {
        $response = $this->actingAs($this->user)
            ->patchJson(route('manga.chapter.update', [$this->manga, $this->chapter]), [
            'volume' => $this->faker->numberBetween(1, 5),
            'number' => $this->faker->numberBetween(0, 1000),
            'name' => $this->faker->name
        ]);

        $response->assertOk();
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson(route('manga.chapter.destroy', [$this->manga, $this->chapter]));

        $response->assertNoContent();
    }
}
