<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name
        ];
    }
}
