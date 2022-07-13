<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Enums\TeamRoleEnum;
use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Http\Resources\InvitationCollection;
use App\Versions\V1\Http\Resources\InvitationResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamInvitationTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->create();
        $this->team = Team::factory()->create();
        $this->user->addToTeam($this->team, TeamRoleEnum::owner->value);
        $this->forbidden = User::factory()->create();
    }

    public function testIndexOk()
    {
        $invitations = Invitation::factory()
            ->for($this->team, 'invited')
            ->count(5)
            ->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('team.invitation.index', $this->team));

        $response->assertOk()
            ->assertJsonFragment(
                (new InvitationCollection($invitations))->response()->getData(true)
            );
    }

    public function testIndexForbidden()
    {
        $response = $this->actingAs($this->forbidden)
            ->getJson(route('team.invitation.index', $this->team));

        $response->assertForbidden();
    }

    public function testShowOk()
    {
        $invitation = Invitation::factory()->for($this->team, 'invited')->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('team.invitation.show', [$this->team, $invitation]));

        $response->assertOk()
            ->assertJsonFragment(
                (new InvitationResource($invitation))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->actingAs($this->user)
            ->getJson(route('team.invitation.show', [$this->team, 'n']));

        $response->assertNotFound();
    }

    public function testShowForbidden()
    {
        $invitation = Invitation::factory()->for($this->team, 'invited')->create();

        $response = $this->actingAs($this->forbidden)
            ->getJson(route('team.invitation.show', [$this->team, $invitation]));

        $response->assertForbidden();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('team.invitation.store', $this->team), [
                'user_id' => User::factory()->create()->id,
                'data' => json_encode(['key' => $this->faker->randomNumber()] )
            ]);

        $response->assertCreated();
    }

    public function testStoreForbidden()
    {
        $response = $this->actingAs($this->forbidden)
            ->postJson(route('team.invitation.store', $this->team), [
                'user_id' => User::factory()->create()->id,
                'data' => json_encode(['key' => $this->faker->randomNumber()] )
            ]);

        $response->assertForbidden();
    }

    public function testUpdateOk()
    {
        $invitation = Invitation::factory()->for($this->team, 'invited')->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('team.invitation.update', [$this->team, $invitation]), [
                'user_id' => User::factory()->create()->id,
                'data' => json_encode(['key' => $this->faker->randomNumber()] )
            ]);

        $response->assertOk();
    }

    public function testUpdateNotFound()
    {
        $response = $this->actingAs($this->user)
            ->patchJson(route('team.invitation.update', [$this->team, 'n']), [
                'user_id' => User::factory()->create()->id,
                'data' => json_encode(['key' => $this->faker->randomNumber()] )
            ]);

        $response->assertNotFound();
    }

    public function testUpdateForbidden()
    {
        $invitation = Invitation::factory()->for($this->team, 'invited')->create();

        $response = $this->actingAs($this->forbidden)
            ->patchJson(route('team.invitation.update', [$this->team, $invitation]), [
                'user_id' => User::factory()->create()->id,
                'data' => json_encode(['key' => $this->faker->randomNumber()] )
            ]);

        $response->assertForbidden();
    }

    public function testDestroyOk()
    {
        $invitation = Invitation::factory()->for($this->team, 'invited')->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('team.invitation.destroy', [$this->team, $invitation]));

        $response->assertNoContent();
    }

    public function testDestroyForbidden()
    {
        $invitation = Invitation::factory()->for($this->team, 'invited')->create();

        $response = $this->actingAs($this->forbidden)
            ->deleteJson(route('team.invitation.destroy', [$this->team, $invitation]));

        $response->assertForbidden();
    }

    public function testDestroyNotFound()
    {
        $response = $this->actingAs($this->user)
            ->patchJson(route('team.invitation.destroy', [$this->team, 'n']));

        $response->assertNotFound();
    }
}
