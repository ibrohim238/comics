<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Enums\TeamRoleEnum;
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
        $this->manga = Manga::factory()->create();
        $this->chapter = Chapter::factory()->create();

        $this->forbidden = User::factory()->create();

        $this->user->teams()->attach($this->team->id, ['role' => TeamRoleEnum::owner->value]);
        $this->manga->teams()->attach($this->team->id);
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
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create([
            'free_at' => null
        ]);

        $response = $this->actingAs($this->user)
            ->getJson(route('manga.chapter.chapter-team.show', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertOk()
            ->assertJsonFragment(
                (new ChapterTeamResource($chapterTeam))->response()->getData(true),
            );
    }

    public function testShowForbidden()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->create([
            'free_at' => $this->faker->dateTimeBetween('+1 days', '+30 days')->format('Y-m-d')
        ]);

        $response = $this->actingAs($this->forbidden)
            ->getJson(route('manga.chapter.chapter-team.show', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertForbidden();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('manga.chapter.chapter-team.store', [$this->manga, $this->chapter]), [
                'teamId' => $this->team->id,
                'free_at' => $this->freeAt()
        ]);

        $response->assertCreated();
    }

    public function testStoreForbidden()
    {
        $response = $this->actingAs($this->forbidden)
            ->postJson(route('manga.chapter.chapter-team.store', [$this->manga, $this->chapter, $this->team]), [
                'teamId' => $this->team->id,
                'free_at' => $this->freeAt()
            ]);

        $response->assertForbidden();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('manga.chapter.chapter-team.store', [$this->manga, $this->chapter]), [
                'teamId' => $this->team->id,
                'free_at' => $this->freeAt()
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        ChapterTeam::factory()->for($this->chapter)->for($this->team)->create();

        $response = $this->actingAs($this->user)
            ->postJson(route('manga.chapter.chapter-team.store', [$this->manga, $this->chapter]), [
                'teamId' => $this->team->id,
                'free_at' => $this->freeAt()
            ]);

        $response->assertOk();
    }

    public function testDeleteOk()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->for($this->team)->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('manga.chapter.chapter-team.destroy', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->for($this->team)->create();

        $response = $this
            ->deleteJson(route('manga.chapter.chapter-team.destroy', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $chapterTeam = ChapterTeam::factory()->for($this->chapter)->for($this->team)->create();

        $response = $this->actingAs($this->forbidden)
            ->deleteJson(route('manga.chapter.chapter-team.destroy', [$this->manga, $this->chapter, $chapterTeam]));

        $response->assertForbidden();
    }

    public function freeAt()
    {
        return $this->faker->randomElement([
            $this->faker->dateTimeBetween('-30 days', '+30 days')->format('Y-m-d'),
            null
        ]);
    }
}
