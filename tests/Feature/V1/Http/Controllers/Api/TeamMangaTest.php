<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function route;

class TeamMangaTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->team = Team::factory()->create();
        $this->user->teams()->attach($this->team->id, ['role' => 'owner']);
    }

    public function testIndexOk()
    {
        $mangas = Manga::factory()->count(10)->create();

        $this->team->mangas()->sync($mangas->pluck('id'));

        $response = $this
            ->getJson(route('teams.manga.index', $this->team));

        $response->assertOk()
            ->assertJsonFragment(
                (new MangaCollection($mangas))->response()->getData(true),
            );
    }

    public function testShowOk()
    {
        $manga = Manga::factory()->create();

        $this->team->mangas()->attach($manga);

        $response = $this->actingAs($this->user)
            ->getJson(route('teams.manga.show', [$this->team, $manga]));

        $response->assertOk()
            ->assertJsonFragment(
                (new MangaResource($manga))->response()->getData(true)
            );
    }

    public function testShowForbidden()
    {
        $manga = Manga::factory()->create();

        $this->team->mangas()->attach($manga);

        $response = $this
            ->getJson(route('teams.manga.show', [$this->team, $manga]));

        $response->assertForbidden();
    }
}
