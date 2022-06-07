<?php

namespace Tests\Feature\V1\Http\Controllers\Api;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class CommentLikeTest extends TestCase
{
    use WithFaker;

    public function testStoreOk()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create();

        $value = $this->faker->numberBetween(0, 1);

        $response = $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($comment::class), $comment->id]), [
                'value' => $value
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.create')
            ]);
    }

    public function testStoreUnauthorized()
    {

        $comment = Comment::factory()->create();


        $response = $this
            ->postJson(route('like.rate', [getMorphedType($comment::class), $comment->id]), [
                'value' => $this->faker->numberBetween(0, 1)
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create();


        $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($comment::class), $comment->id]), [
                'value' => $this->faker->numberBetween(0, 1)
            ]);

        $value = $this->faker->numberBetween(0, 1);

        $response = $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($comment::class), $comment->id]), [
                'value' => $value
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.create')
            ]);
    }

    public function testDeleteOk()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create();

        $this->actingAs($user)
            ->postJson(route('like.rate', [getMorphedType($comment::class), $comment->id]), [
                'value' => $this->faker->numberBetween(0, 1)
            ]);

        $response = $this->actingAs($user)
            ->deleteJson(route('like.un-rate', [getMorphedType($comment::class), $comment->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.delete')
            ]);
    }

    public function testDeleteBusy()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('like.un-rate', [getMorphedType($comment::class), $comment->id]));

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => Lang::get('rateable.notFound')
            ]);
    }

    public function testDeleteUnauthorized()
    {

        $comment = Comment::factory()->create();

        $response = $this
            ->deleteJson(route('like.un-rate', [getMorphedType($comment::class), $comment->id]));

        $response->assertUnauthorized();
    }
}
