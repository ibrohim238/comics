<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $commentable = $this->commentable();

        return [
            'content' => $this->faker->sentence(),
            'user_id' => User::factory(),
            'commentable_id' => $commentable::factory(),
            'commentable_type' => getMorphedType($commentable),
        ];
    }

    public function commentable()
    {
        return $this->faker->randomElement([
            Manga::class,
            Chapter::class,
        ]);
    }
}
