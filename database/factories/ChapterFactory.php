<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    protected $model = Chapter::class;

    public function definition(): array
    {
        return [
            'volume' => 1,
            'number' => $this->faker->numberBetween(0, 100),
            'name' => $this->faker->title,
            'order_column' =>  $this->faker->numberBetween(0, 100),
            'manga_id' => Manga::factory()
        ];
    }
}
