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

    private Team $team;
    private Manga $manga;
    private User $user;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->team = Team::factory()->create();
        $this->manga = Manga::factory()->create();
        $this->user = User::factory()->create();

        $this->user->addToTeam($this->team,'owner');

        $this->team->mangas()->attach($this->manga->id);
    }

    public function testIndexOk()
    {
        $chapters = Chapter::factory()
            ->for($this->manga)
            ->for($this->team)
            ->count(3)
            ->create();

        $response = $this->getJson(route('chapter.index'));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new ChapterCollection($chapters->load('team')))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $chapter = Chapter::factory()->for($this->manga)->create();
        
        $response = $this->getJson(route('chapter.show', $chapter));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterResource($chapter->load('manga.media')))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('chapter.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('chapter.store'), [
            'volume' => $this->faker->numberBetween(1, 5),
            'number' => $this->faker->numberBetween(0, 1000),
            'name' => $this->faker->name,
            'team_id' => $this->team->id,
            'manga_id' => $this->manga->id,
        ]);

        $response->assertCreated();
    }

    public function testUpdateOk()
    {
        $chapter = Chapter::factory()
            ->for($this->manga)
            ->for($this->team)
            ->create();
        
        $response = $this->actingAs($this->user)
            ->patchJson(route('chapter.update', $chapter), [
            'volume' => $this->faker->numberBetween(1, 5),
            'number' => $this->faker->numberBetween(0, 1000),
            'name' => $this->faker->name
        ]);

        $response->assertOk();
    }

    public function testDestroyOk()
    {
        $chapter = Chapter::factory()
            ->for($this->manga)
            ->for($this->team)
            ->create();
        
        $response = $this->actingAs($this->user)
            ->deleteJson(route('chapter.destroy', $chapter));

        $response->assertNoContent();
    }
}
