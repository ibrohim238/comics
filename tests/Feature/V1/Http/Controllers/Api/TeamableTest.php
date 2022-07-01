<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class TeamableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->user = User::factory()->create()->assignRole('owner');
        $this->team = Team::factory()->create();
        $this->manga = Manga::factory()->create();
        $this->forbidden = User::factory()->create();
    }

    public function testAttachOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('team.manga.attach', [$this->team, getMorphedType($this->manga::class), $this->manga->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('teamable.attach')
            ]);
    }

    public function testAttachUnauthorized()
    {
        $response = $this
            ->postJson(route('team.manga.attach', [$this->team, getMorphedType($this->manga::class), $this->manga->id]));

        $response->assertUnauthorized();
    }

    public function testAttachForbidden()
    {
        $response = $this->actingAs($this->forbidden)
            ->postJson(route('team.manga.attach', [$this->team, getMorphedType($this->manga::class), $this->manga->id]));

        $response->assertForbidden();
    }

    public function testDetachOk()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson(route('team.manga.detach', [$this->team, getMorphedType($this->manga::class), $this->manga->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('teamable.detach')
            ]);
    }

    public function testDetachUnauthorized()
    {
        $response = $this
            ->deleteJson(route('team.manga.detach', [$this->team, getMorphedType($this->manga::class), $this->manga->id]));

        $response->assertUnauthorized();
    }

    public function testDetachForbidden()
    {
        $response = $this->actingAs($this->forbidden)
            ->deleteJson(route('team.manga.detach', [$this->team, getMorphedType($this->manga::class), $this->manga->id]));

        $response->assertForbidden();
    }
}
