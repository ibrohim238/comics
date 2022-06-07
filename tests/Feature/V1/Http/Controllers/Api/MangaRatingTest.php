<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class MangaRatingTest extends TestCase
{
    use WithFaker;

    public function testStoreOk()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $value = $this->faker->numberBetween(0, 5);

        $response = $this->actingAs($user)
            ->postJson(route('rating.rate', [getMorphedType($manga::class), $manga->id]), [
                'value' => $value
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.rating.create', ['value' => $value])
            ]);
    }

    public function testStoreUnauthorized()
    {

        $manga = Manga::factory()->create();


        $response = $this
            ->postJson(route('rating.rate', [getMorphedType($manga::class), $manga->id]), [
                'value' => $this->faker->numberBetween(1, 5)
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateOk()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();


        $this->actingAs($user)
            ->postJson(route('rating.rate', [getMorphedType($manga::class), $manga->id]), [
                'value' => $this->faker->numberBetween(1, 5)
            ]);

        $value = $this->faker->numberBetween(1, 5);

        $response = $this->actingAs($user)
            ->postJson(route('rating.rate', [getMorphedType($manga::class), $manga->id]), [
                'value' => $value
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.rating.create', ['value' => $value])
            ]);
    }

    public function testDeleteOk()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $this->actingAs($user)
            ->postJson(route('rating.rate', [getMorphedType($manga::class), $manga->id]), [
                'value' => $this->faker->numberBetween(1, 5)
            ]);

        $response = $this->actingAs($user)
            ->deleteJson(route('rating.un-rate', [getMorphedType($manga::class), $manga->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('rateable.delete')
            ]);
    }

    public function testDeleteBusy()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('rating.un-rate', [getMorphedType($manga::class), $manga->id]));

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => Lang::get('rateable.notFound')
            ]);
    }

    public function testDeleteUnauthorized()
    {

        $manga = Manga::factory()->create();


        $response = $this
            ->deleteJson(route('rating.un-rate', [getMorphedType($manga::class), $manga->id]), [
                'value' => $this->faker->numberBetween(1, 5)
            ]);

        $response->assertUnauthorized();
    }
}
