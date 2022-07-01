<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    protected $model = Chapter::class;

    public function definition(): array
    {
        return [
            'volume' => $this->faker->numberBetween(1,5),
            'number' => $this->faker->numberBetween(0, 100),
            'name' => $this->faker->title,
            'manga_id' => Manga::factory(),
        ];
    }
}
