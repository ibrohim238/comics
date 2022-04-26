<?php

namespace Database\Factories;

use App\Models\Manga;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MangaFactory extends Factory
{
    protected $model = Manga::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->title,
            'description' => $this->faker->text,
            'published_at' => Carbon::now(),
        ];
    }
}
