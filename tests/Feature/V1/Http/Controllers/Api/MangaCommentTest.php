<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Manga;
use App\Models\User;
use App\Versions\V1\Http\Resources\CommentCollection;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MangaCommentTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->manga = Manga::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testIndexOk()
    {
        $comments = Comment::factory()->for($this->manga, 'commentable')->count(10)->create();

        $response = $this->getJson(route('comment.index', [getMorphedType($this->manga::class), $this->manga->id]));

        $response->assertOk()
            ->assertJsonFragment(
                (new CommentCollection($comments->load('user')))->response()->getData(true)
            );
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('comment.store', [getMorphedType($this->manga::class), $this->manga->id]), [
                'content' => $this->faker->text
            ]);

        $response->assertCreated();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('comment.store', [getMorphedType($this->manga::class), $this->manga->id]), [
                'content' => $this->faker->text
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $comment = Comment::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('comment.update', $comment), [
               'content' => $this->faker->text
            ]);

        $response->assertOk();
    }

    public function testUpdateUnauthorized()
    {
        $comment = Comment::factory()->create();

        $response = $this
            ->patchJson(route('comment.update', $comment), [
                'content' => $this->faker->text
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateForbidden()
    {
        $comment = Comment::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('comment.update', $comment), [
                'content' => $this->faker->text
            ]);

        $response->assertForbidden();
    }

    public function testDeleteOk()
    {
        $comment = Comment::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('comment.destroy', $comment));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $comment = Comment::factory()->for($this->user)->create();

        $response = $this
            ->deleteJson(route('comment.destroy', $comment));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $comment = Comment::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('comment.destroy', $comment));

        $response->assertForbidden();
    }
}
