<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Enums\RolePermissionEnum;
use App\Models\Manga;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use IAleroy\Tags\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;
use function route;

class MangaTest extends TestCase
{
    use WithFaker;

    private Collection $tags;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->user = User::factory()->create();
        $this->tags = Tag::factory()->count(10)->create()->pluck('id');

        $this->user->assignRole('owner');
    }

    public function testIndexOk()
    {
        $mangas = Manga::factory()->count('3')->create();

        $response = $this->getJson(route('manga.index'));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new MangaCollection($mangas))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $manga = Manga::factory()->create();

            $response = $this->getJson(route('manga.show', $manga));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new MangaResource($manga->load('tags')))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('manga.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('manga.store'), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response->assertCreated();
    }

    public function testStoreErrorValidateName()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('manga.store'), [
                'name' => 'err',
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response
            ->assertJsonValidationErrors(['name'])
            ->assertUnprocessable();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('manga.store'), [
                'name' => 'err',
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response->assertUnauthorized();
    }

    public function testStoreForbidden()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('manga.store'), [
                'name' => 'err',
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response->assertForbidden();
    }

    public function testUpdateOk()
    {
        $manga = Manga::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('manga.update', $manga), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response->assertOk();
    }

    public function testUpdateUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this
            ->patchJson(route('manga.update', $manga), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateForbidden()
    {
        $user = User::factory()->create();
        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)
            ->patchJson(route('manga.update', $manga), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response->assertForbidden();
    }

    public function testUpdateNotFound()
    {
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $response = $this->actingAs($user)
            ->patchJson(route('manga.update', 'n'), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'is_published' => $this->faker->boolean,
                'tags' => $this->tags
            ]);

        $response->assertNotFound();
    }

    public function testDeleteOk()
    {
        $manga = Manga::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('manga.destroy', $manga));

        $response->assertNoContent();
    }

    public function testDeleteNotFound()
    {
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $response = $this->actingAs($user)
            ->deleteJson(route('manga.destroy', 'n'));

        $response->assertNotFound();
    }

    public function testDeleteUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this
            ->deleteJson(route('manga.destroy', $manga));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('manga.destroy', $manga));

        $response->assertForbidden();
    }
}
