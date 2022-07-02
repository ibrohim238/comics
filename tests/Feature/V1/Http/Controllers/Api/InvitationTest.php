<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Invitation;
use App\Models\User;
use App\Versions\V1\Http\Resources\InvitationCollection;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testIndexOk()
    {
        $invitations = Invitation::factory()->count(4)->for($this->user)->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('user.invitation.index', $this->user));

        $response->assertOk()
            ->assertJsonFragment(
                (new InvitationCollection($invitations))->response()->getData(true)
            );
    }

    public function testIndexUnauthorized()
    {
        $response = $this->getJson(route('user.invitation.index', $this->user));

        $response->assertUnauthorized();
    }

    public function testAcceptOk()
    {
        $invitation = Invitation::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user)
            ->postJson(route('user.invitation.accept', [$this->user, $invitation]));

        $response->assertOk();
    }

    public function testAcceptUnauthorized()
    {
        $invitation = Invitation::factory()->for($this->user)->create();

        $response = $this
            ->postJson(route('user.invitation.accept', [$this->user, $invitation]));

        $response->assertUnauthorized();
    }

    public function testRejectOk()
    {
        $invitation = Invitation::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('user.invitation.reject', [$this->user, $invitation]));

        $response->assertOk();
    }

    public function testRejectUnauthorized()
    {
        $invitation = Invitation::factory()->for($this->user)->create();

        $response = $this
            ->deleteJson(route('user.invitation.reject', [$this->user, $invitation]));

        $response->assertUnauthorized();
    }
}
