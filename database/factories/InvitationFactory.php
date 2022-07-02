<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\Manga;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        return [
            'invited_type' => getMorphedType(Team::class),
            'invited_id' => Team::factory(),
            'user_id' => User::factory(),
            'data' => $this->faker->text
        ];
    }

}
