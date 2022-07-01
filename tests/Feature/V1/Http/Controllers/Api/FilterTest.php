<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Filter;
use App\Models\User;
use App\Versions\V1\Http\Resources\FilterCollection;
use App\Versions\V1\Http\Resources\FilterResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterTest extends TestCase
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
        $filters = Filter::factory()->count(5)->create();

        $response = $this->getJson(route('filter.index'));

        $response->assertOk()
            ->assertJsonFragment(
                (new FilterCollection($filters))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $filter = Filter::factory()->create();

        $response = $this->getJson(route('filter.show', $filter));

        $response->assertOk()
            ->assertJsonFragment(
                (new FilterResource($filter))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('filter.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('filter.store'), [
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
            ->postJson(route('filter.store'), [
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
            ->postJson(route('filter.store'), [
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
        $filter = Filter::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('filter.update', $filter), [
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
        $filter = Filter::factory()->create();

        $response = $this
            ->patchJson(route('filter.update', $filter), [
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
        $filter = Filter::factory()->create();

        $response = $this->actingAs($user)
            ->patchJson(route('filter.update', $filter), [
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
        $filter = Filter::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('filter.destroy', $filter));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $filter = Filter::factory()->create();

        $response = $this
            ->deleteJson(route('filter.destroy', $filter));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $user = User::factory()->create();
        $filter = Filter::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('filter.destroy', $filter));

        $response->assertForbidden();
    }
}
