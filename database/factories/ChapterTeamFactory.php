<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Team;
use App\Models\ChapterTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterTeamFactory extends Factory
{
    protected $model = ChapterTeam::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'chapter_id' => Chapter::factory(),
            'free_at' => $this->faker->dateTimeBetween('-30 days', '+30 days')
        ];
    }
}
