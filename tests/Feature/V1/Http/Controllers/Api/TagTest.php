<?php

namespace Tests\Feature\V1\Http\Controllers\Api;
use App\Models\User;
use App\Versions\V1\Http\Resources\TagCollection;
use App\Versions\V1\Http\Resources\TagResource;
use IAleroy\Tags\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::factory()->create();

        $this->user->assignRole('owner');
    }

    public function testIndexOk()
    {
        $tags = Tag::factory()->count(5)->create();

        $response = $this->getJson(route('tags.index'));

        $response->assertOk()
            ->assertJsonFragment(
                (new TagCollection($tags))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $tag = Tag::factory()->create();

        $response = $this->getJson(route('tags.show', $tag));

        $response->assertOk()
            ->assertJsonFragment(
                (new TagResource($tag))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('tags.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('tags.store'), [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'type' => $this->faker->randomElement([
                'genre',
                'category',
                'tag'
            ])
        ]);

        $response->assertCreated();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('tags.store'), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'type' => $this->faker->randomElement([
                    'genre',
                    'category',
                    'tag'
                ])
            ]);

        $response->assertUnauthorized();
    }

    public function testStoreForbidden()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('tags.store'), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'type' => $this->faker->randomElement([
                    'genre',
                    'category',
                    'tag'
                ])
            ]);

        $response->assertForbidden();
    }

    public function testUpdateOk()
    {
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('tags.update', $tag), [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'type' => $this->faker->randomElement([
                'genre',
                'category',
                'tag'
            ])
        ]);

        $response->assertOk();
    }

    public function testUpdateUnauthorized()
    {
        $tag = Tag::factory()->create();

        $response = $this
            ->patchJson(route('tags.update', $tag), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'type' => $this->faker->randomElement([
                    'genre',
                    'category',
                    'tag'
                ])
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateForbidden()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)
            ->patchJson(route('tags.update', $tag), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'type' => $this->faker->randomElement([
                    'genre',
                    'category',
                    'tag'
                ])
            ]);

        $response->assertForbidden();
    }

    public function testDeleteOk()
    {
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('tags.destroy', $tag));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $tag = Tag::factory()->create();

        $response = $this
            ->deleteJson(route('tags.destroy', $tag));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('tags.destroy', $tag));

        $response->assertForbidden();
    }
}
