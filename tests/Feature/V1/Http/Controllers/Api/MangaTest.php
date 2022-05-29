<?php

namespace Tests\Feature\V1\Http\Api\Controllers;

use App\Models\Manga;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function route;

class NotebookTest extends TestCase
{
    use WithFaker;

    public function testIndexOk()
    {
        $manga = Manga::factory()->create()->loadAvg('ratings', 'rating');

        $response = $this->getJson(route('coupon.index'));

        $response
            ->assertOk()
            ->assertJsonFragment([
               'data' => [
                   [
                       'id' => $manga->id,
                       'name' => $manga->name,
                       'slug' => $manga->slug,
                       'description' => $manga->description,
                       'media' => $manga->getFirstMediaUrl(),
                       'rating' => round($mangaRating->manga_ratings_avg_rating ?? 0, 2)
                   ]
               ]
            ]);
    }

    public function testShowOk()
    {
        $manga = Manga::factory()->create()->loadAvg('ratings', 'rating');

        $response = $this->getJson(route('coupon.show'));

        $response
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    'id' => $manga->id,
                    'name' => $manga->name,
                    'slug' => $manga->slug,
                    'description' => $manga->description,
                    'media' => $manga->getFirstMediaUrl(),
                    'rating' => round($mangaRating->manga_ratings_avg_rating ?? 0, 2)
                ]
            ]);
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('coupon.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->postJson(route('manga.store'), [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'published_at' => $this->faker->dateTime
        ]);

        $response->assertCreated();
    }

    public function testStoreErrorValidateName()
    {
        $response = $this->postJson(route('manga.store'), [
            'name' => 'err',
            'description' => $this->faker->text,
            'published_at' => $this->faker->dateTime,
        ]);

        $response
            ->assertJsonValidationErrors('name')
            ->assertUnprocessable();
    }

    public function testUpdateOk()
    {
        $manga = Manga::factory()->create();

        $response = $this->patchJson(route('manga.update', $manga), [
           'name' => $this->faker->name,
           'description'  => $this->faker->text,
           'published_at' => $this->faker->dateTime,
        ]);

        $response->assertOk();
    }

    public function testUpdateNotFound()
    {
        $response = $this->patchJson(route('manga.update', 'n'), [
            'name' => $this->faker->name,
            'description'  => $this->faker->text,
            'published_at' => $this->faker->dateTime,
        ]);

        $response->assertNotFound();
    }

    public function testDeleteOk()
    {
        $manga = Manga::factory()->create();

        $response = $this->deleteJson(route('manga.destroy', $manga));

        $response->assertNoContent();
    }

    public function testDeleteNotFound()
    {
        $response = $this->deleteJson(route('manga.destroy', 'n'));

        $response->assertNotFound();
    }
}
