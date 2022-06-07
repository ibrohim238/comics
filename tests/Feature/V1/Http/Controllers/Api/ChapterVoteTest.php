<?php

namespace Tests\Feature\V1\Http\Controllers\Api;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class ChapterVoteTest extends TestCase
{
    use WithFaker;

    public function testStoreOk()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('vote.rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.create')
            ]);
    }

    public function testStoreUnauthorized()
    {

        $chapter = Chapter::factory()->create();

        $response = $this
            ->postJson(route('vote.rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();


        $this->actingAs($user)
            ->postJson(route('vote.rate', [getMorphedType($chapter::class), $chapter->id]));

        $response = $this->actingAs($user)
            ->postJson(route('vote.rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.create')
            ]);
    }

    public function testDeleteOk()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();

        $this->actingAs($user)
            ->postJson(route('vote.rate', [getMorphedType($chapter::class), $chapter->id]));

        $response = $this->actingAs($user)
            ->deleteJson(route('vote.un-rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.delete')
            ]);
    }

    public function testDeleteBusy()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('vote.un-rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => Lang::get('rateable.notFound')
            ]);
    }

    public function testDeleteUnauthorized()
    {
        $chapter = Chapter::factory()->create();

        $response = $this
            ->deleteJson(route('vote.un-rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertUnauthorized();
    }
}
