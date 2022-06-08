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

class TeamMangaChapterTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->team = Team::factory()->create();
        $this->user->teams()->attach($this->team->id, ['role' => 'owner']);
        $this->manga = Manga::factory()->create();
        $this->manga->teams()->attach($this->team->id);
    }

    public function testIndexOk()
    {
        $chapters = Chapter::factory()->count(5)->for($this->manga)->for($this->team)->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('teams.manga.chapter.index', [$this->team, $this->manga]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterCollection($chapters))->response()->getData(true),
            );
    }

    public function testIndexUnauthorized()
    {
        $response = $this
            ->getJson(route('teams.manga.chapter.index', [$this->team, $this->manga]));

        $response->assertUnauthorized();
    }

    public function testIndexForbidden()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('teams.manga.chapter.index', [$this->team, $this->manga]));

        $response->assertForbidden();
    }

    public function testShowOk()
    {
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('teams.manga.chapter.show', [$this->team, $this->manga, $chapter]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterResource($chapter))->response()->getData(true),
            );
    }

    public function testShowUnauthorized()
    {
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this
            ->getJson(route('teams.manga.chapter.show', [$this->team, $this->manga, $chapter]));

        $response->assertUnauthorized();
    }

    public function testShowForbidden()
    {
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('teams.manga.chapter.show', [$this->team, $this->manga, $chapter]));

        $response->assertForbidden();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('teams.manga.chapter.store', [$this->team, $this->manga]), [
                'volume' => 1,
                'number' => $this->faker->numberBetween(0, 100),
                'name' => $this->faker->title,
                'is_paid' => $this->faker->boolean,
        ]);

        $response->assertCreated();
    }

    public function testStoreForbidden()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('teams.manga.chapter.store', [$this->team, $this->manga]), [
                'volume' => 1,
                'number' => $this->faker->numberBetween(0, 100),
                'name' => $this->faker->title,
                'is_paid' => $this->faker->boolean,
            ]);

        $response->assertForbidden();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('teams.manga.chapter.store', [$this->team, $this->manga]), [
                'volume' => 1,
                'number' => $this->faker->numberBetween(0, 100),
                'name' => $this->faker->title,
                'is_paid' => $this->faker->boolean,
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('teams.manga.chapter.update', [$this->team, $this->manga, $chapter]), [
                'volume' => 1,
                'number' => $this->faker->numberBetween(0, 100),
                'name' => $this->faker->title,
                'is_paid' => $this->faker->boolean,
            ]);

        $response->assertOk();
    }

    public function testUpdateUnauthorized()
    {
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this
            ->patchJson(route('teams.manga.chapter.update', [$this->team, $this->manga, $chapter]), [
                'volume' => 1,
                'number' => $this->faker->numberBetween(0, 100),
                'name' => $this->faker->title,
                'is_paid' => $this->faker->boolean,
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateForbidden()
    {
        $user = User::factory()->create();
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this->actingAs($user)
            ->patchJson(route('teams.manga.chapter.update', [$this->team, $this->manga, $chapter]), [
                'volume' => 1,
                'number' => $this->faker->numberBetween(0, 100),
                'name' => $this->faker->title,
                'is_paid' => $this->faker->boolean,
            ]);

        $response->assertForbidden();
    }

    public function testDeleteOk()
    {
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('teams.manga.chapter.destroy', [$this->team, $this->manga, $chapter]));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this
            ->deleteJson(route('teams.manga.chapter.destroy', [$this->team, $this->manga, $chapter]));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $user = User::factory()->create();
        $chapter = Chapter::factory()->for($this->manga)->for($this->team)->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('teams.manga.chapter.destroy', [$this->team, $this->manga, $chapter]));

        $response->assertForbidden();
    }
}
