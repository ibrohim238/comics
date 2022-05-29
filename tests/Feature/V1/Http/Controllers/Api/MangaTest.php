<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Enums\RolePermissionEnum;
use App\Models\Manga;
use App\Models\User;
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
    }

    public function testIndexOk()
    {
        $manga = Manga::factory()->create()->loadAvg('ratings', 'rating');

        $response = $this->getJson(route('mangas.index'));

        $response
            ->assertOk()
            ->assertJsonFragment([
               'data' => [
                   [
                       'id' => $manga->id,
                       'name' => $manga->name,
                       'slug' => $manga->slug,
                       'description' => $manga->description,
                       'media' => null,
                       'rating' => round($mangaRating->manga_ratings_avg_rating ?? 0, 2)
                   ]
               ]
            ]);
    }

    public function testShowOk()
    {
        $manga = Manga::factory()->create()->loadAvg('ratings', 'rating');

        $response = $this->getJson(route('mangas.show', $manga));

        $response
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    'id' => $manga->id,
                    'name' => $manga->name,
                    'slug' => $manga->slug,
                    'description' => $manga->description,
                    'media' => null,
                    'rating' => round($mangaRating->manga_ratings_avg_rating ?? 0, 2)
                ]
            ]);
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('mangas.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $response = $this->actingAs($user)
            ->postJson(route('mangas.store'), [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'published_at' => $this->faker->dateTime
        ]);

        $response->assertCreated();
    }

    public function testStoreErrorValidateName()
    {
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $response = $this->actingAs($user)
            ->postJson(route('mangas.store'), [
            'name' => 'err',
            'description' => $this->faker->text,
            'published_at' => $this->faker->dateTime,
        ]);

        $response
            ->assertJsonValidationErrors(['name'])
            ->assertUnprocessable();
    }

    public function testUpdateOk()
    {
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)
            ->patchJson(route('mangas.update', $manga), [
           'name' => $this->faker->name,
           'description'  => $this->faker->text,
           'published_at' => $this->faker->dateTime,
        ]);

        $response->assertOk();
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
        $user = User::factory()->create()
            ->assignRole(RolePermissionEnum::OWNER->value);

        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)
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
}
