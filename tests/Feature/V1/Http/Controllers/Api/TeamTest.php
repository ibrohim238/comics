<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Http\Resources\TeamCollection;
use App\Versions\V1\Http\Resources\TeamResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->user = User::factory()->create()->assignRole('owner');
        $this->forbidden = User::factory()->create();
    }

    public function testIndexOk()
    {
        $teams = Team::factory()->count(10)->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('team.index'));

        $response->assertOk()
            ->assertJsonFragment(
                (new TeamCollection($teams))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $team = Team::factory()->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('team.show', $team));

        $response->assertOk()
            ->assertJsonFragment(
                (new TeamResource($team))->response()->getData(true)
            );
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('team.store'), [
                'name' => $this->faker->name,
            ]);

        $response->assertCreated();
    }

    public function testStoreForbidden()
    {
        $response = $this->actingAs($this->forbidden)
            ->postJson(route('team.store'), [
                'name' => $this->faker->name
            ]);

        $response->assertForbidden();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('team.store'), [
                'name' => $this->faker->name
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $team = Team::factory()->create();

        $this->user->addToTeam($team,'owner');
        $response = $this->actingAs($this->user)
            ->patchJson(route('team.update', $team), [
                'name' => $this->faker->name
            ]);

        $response->assertOk();
    }

    public function testUpdateForbidden()
    {
        $team = Team::factory()->create();

        $response = $this->actingAs($this->forbidden)
            ->patchJson(route('team.update', $team), [
                'name' => $this->faker->name
            ]);

        $response->assertForbidden();
    }

    public function testUpdateUnauthorized()
    {
        $team = Team::factory()->create();

        $response = $this
            ->patchJson(route('team.update', $team), [
                'name' => $this->faker->name
            ]);

        $response->assertUnauthorized();
    }

    public function testDeleteOk()
    {
        $team = Team::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('team.destroy', $team));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $team = Team::factory()->create();

        $response = $this
            ->deleteJson(route('team.destroy', $team));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $team = Team::factory()->create();

        $response = $this->actingAs($this->forbidden)
            ->deleteJson(route('team.destroy', $team));

        $response->assertForbidden();
    }
}
