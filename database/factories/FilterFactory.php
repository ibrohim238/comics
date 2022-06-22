<?php

namespace Database\Factories;

use App\Models\Filter;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilterFactory extends Factory
{
    protected $model = Filter::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'type' => $this->type()
        ];
    }

    public function type(): string
    {
        return $this->faker->randomElement([
            'genre',
            'category',
            'tag'
        ]);
    }
}
