<?php

namespace Database\Factories;

use App\Models\Graduation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GraduationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Graduation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
        ];
    }
}
