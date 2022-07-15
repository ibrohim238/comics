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

        $response = $this->getJson(route('team.manga.chapter.index', [$this->team, $this->manga]));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new ChapterCollection($chapters->load('team')))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $chapter = Chapter::factory()->for($this->manga)->create();
        
        $response = $this->getJson(route('team.manga.chapter.show', [$this->team, $this->manga, $chapter]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterResource($chapter->load('manga.media')))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('team.manga.chapter.show', [$this->team, $this->manga, 'n']));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('team.manga.chapter.store', [$this->team, $this->manga]), [
            'volume' => $this->faker->numberBetween(1, 5),
            'number' => $this->faker->numberBetween(0, 1000),
            'name' => $this->faker->name
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
            ->patchJson(route('team.manga.chapter.update', [$this->team, $this->manga, $chapter]), [
            'volume' => $this->faker->numberBetween(1, 5),
            'number' => $this->faker->numberBetween(0, 1000),
            'name' => $this->faker->name
        ]);

        $response->assertOk();
    }

    public function testDestroyOk()
    {
        $chapter = Chapter::factory()->for($this->manga)->create();
        
        $response = $this->actingAs($this->user)
            ->deleteJson(route('team.manga.chapter.destroy', [$this->team, $this->manga, $chapter]));

        $response->assertNoContent();
    }
}
