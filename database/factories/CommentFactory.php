<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Manga;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
