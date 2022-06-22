<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Enums\RolePermissionEnum;
use App\Models\Manga;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function route;

class MangaTest extends TestCase
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
        $mangas = Manga::factory()->count('3')->create();

        $response = $this->getJson(route('mangas.index'));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new MangaCollection($mangas))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $manga = Manga::factory()->create();

        $response = $this->getJson(route('mangas.show', $manga));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new MangaResource($manga))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('mangas.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('mangas.store'), [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'published_at' => $this->faker->dateTime
        ]);

        $response->assertCreated();
    }

    public function testStoreErrorValidateName()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('mangas.store'), [
            'name' => 'err',
            'description' => $this->faker->text,
            'published_at' => $this->faker->dateTime,
        ]);

        $response
            ->assertJsonValidationErrors(['name'])
            ->assertUnprocessable();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('mangas.store'), [
                'name' => 'err',
                'description' => $this->faker->text,
                'published_at' => $this->faker->dateTime,
            ]);

        $response->assertUnauthorized();
    }

    public function testStoreForbidden()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('mangas.store'), [
                'name' => 'err',
                'description' => $this->faker->text,
                'published_at' => $this->faker->dateTime,
            ]);

        $response->assertForbidden();
    }

    public function testUpdateOk()
    {
        $manga = Manga::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('mangas.update', $manga), [
           'name' => $this->faker->name,
           'description'  => $this->faker->text,
           'published_at' => $this->faker->dateTime,
        ]);

        $response->assertOk();
    }

    public function testUpdateUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this
            ->patchJson(route('mangas.update', $manga), [
                'name' => $this->faker->name,
                'description'  => $this->faker->text,
                'published_at' => $this->faker->dateTime,
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateForbidden()
    {
        $user = User::factory()->create();
        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)
            ->patchJson(route('mangas.update', $manga), [
                'name' => $this->faker->name,
                'description'  => $this->faker->text,
                'published_at' => $this->faker->dateTime,
            ]);

        $response->assertForbidden();
    }

    public function testUpdateNotFound()
    {
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $response = $this->actingAs($user)
            ->patchJson(route('mangas.update', 'n'), [
            'name' => $this->faker->name,
            'description'  => $this->faker->text,
            'published_at' => $this->faker->dateTime,
        ]);

        $response->assertNotFound();
    }

    public function testDeleteOk()
    {
        $manga = Manga::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('mangas.destroy', $manga));

        $response->assertNoContent();
    }

    public function testDeleteNotFound()
    {
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $response = $this->actingAs($user)
            ->deleteJson(route('mangas.destroy', 'n'));

        $response->assertNotFound();
    }

    public function testDeleteUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this
            ->deleteJson(route('mangas.destroy', $manga));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('mangas.destroy', $manga));

        $response->assertForbidden();
    }
}
