<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class ChapterLikeTest extends TestCase
{
    use WithFaker;

    public function testStoreOk()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();

        $value = $this->faker->numberBetween(0, 1);

        $response = $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($chapter::class), $chapter->id]), [
                'value' => $value
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::choice('rateable.like.create', $value)
            ]);
    }

    public function testAttachUnauthorized()
    {

        $chapter = Chapter::factory()->create();


        $response = $this
            ->postJson(route('like.rate', [getMorphedType($chapter::class), $chapter->id]), [
                'value' => $this->faker->numberBetween(0, 1)
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();


        $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($chapter::class), $chapter->id]), [
                'value' => $this->faker->numberBetween(0, 1)
            ]);

        $value = $this->faker->numberBetween(0, 1);

        $response = $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($chapter::class), $chapter->id]), [
                'value' => $value
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::choice('rateable.like.create', $value)
            ]);
    }

    public function testDetachOk()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();

        $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($chapter::class), $chapter->id]), [
                'value' => $this->faker->numberBetween(0, 1)
            ]);

        $response = $this->actingAs($user)
            ->deleteJson(route('like.un-rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.delete')
            ]);
    }

    public function testDetachBusy()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('like.un-rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => Lang::get('rateable.notFound')
            ]);
    }

    public function testDetachUnauthorized()
    {

        $chapter = Chapter::factory()->create();


        $response = $this
            ->deleteJson(route('like.un-rate', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertUnauthorized();
    }
}
