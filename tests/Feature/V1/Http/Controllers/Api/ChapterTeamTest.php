<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Models\ChapterTeam;
use App\Models\User;
use App\Versions\V1\Http\Requests\Api\ChapterTeamRequest;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use App\Versions\V1\Http\Resources\ChapterTeamCollection;
use App\Versions\V1\Http\Resources\ChapterTeamResource;
use App\Versions\V1\Services\ChapterTeamService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function route;

class ChapterTeamTest extends TestCase
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
        $this->chapter = Chapter::factory()->create();

        $this->forbidden = User::factory()->create();
    }

    public function testIndexOk()
    {
        $chapterTeams = ChapterTeam::factory()->for($this->chapter)->count(10)->create();

        $response = $this
            ->getJson(route('manga.chapter.chapter-team.index', [$this->manga, $this->chapter]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterTeamCollection($chapterTeams))->response()->getData(true),
            );
    }

    public function testShowOk()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('manga.chapter.chapter-team.show', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterTeamResource($chapterTeam))->response()->getData(true),
            );
    }

    public function testShowForbidden()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this->actingAs($this->forbidden)
            ->getJson(route('manga.chapter.chapter-team.show', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertForbidden();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('manga.chapter.chapter-team.store', [$this->manga, $this->chapter, $this->team]), [
                'free_at' => $this->faker->randomElement([
                    $this->faker->dateTimeBetween('-30 days', '+30 days'),
                    null
                ])
        ]);

        $response->assertCreated();
    }

    public function testStoreForbidden()
    {
        $response = $this->actingAs($this->forbidden)
            ->postJson(route('manga.chapter.chapter-team.store', [$this->manga, $this->chapter, $this->team]), [
                'free_at' => $this->faker->randomElement([
                    $this->faker->dateTimeBetween('-30 days', '+30 days'),
                    null
                ])
            ]);

        $response->assertForbidden();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('manga.chapter.chapter-team.store', [$this->manga, $this->chapter, $this->team]), [
                'free_at' => $this->faker->randomElement([
                    $this->faker->dateTimeBetween('-30 days', '+30 days'),
                    null
                ])
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('manga.chapter.chapter-team.update', [$this->manga, $this->chapter, $chapterTeam]), [
                'free_at' => $this->faker->randomElement([
                    $this->faker->dateTimeBetween('-30 days', '+30 days'),
                    null
                ])
            ]);

        $response->assertOk();
    }

    public function testUpdateUnauthorized()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this
            ->patchJson(route('manga.chapter.chapter-team.update', [$this->manga, $this->chapter, $chapterTeam]), [
                'free_at' => $this->faker->randomElement([
                    $this->faker->dateTimeBetween('-30 days', '+30 days'),
                    null
                ])
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateForbidden()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this->actingAs($this->forbidden)
            ->patchJson(route('manga.chapter.chapter-team.update', [$this->manga, $this->chapter, $chapterTeam]), [
                'free_at' => $this->faker->randomElement([
                    $this->faker->dateTimeBetween('-30 days', '+30 days'),
                    null
                ])
            ]);

        $response->assertForbidden();
    }

    public function testDeleteOk()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('manga.chapter.chapter-team.destroy', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this
            ->deleteJson(route('manga.chapter.chapter-team.destroy', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create();

        $response = $this->actingAs($this->forbidden)
            ->deleteJson(route('manga.chapter.chapter-team.destroy', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertForbidden();
    }
}
