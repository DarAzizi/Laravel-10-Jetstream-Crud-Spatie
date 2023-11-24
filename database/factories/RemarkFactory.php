<?php

namespace Database\Factories;

use App\Models\Remark;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RemarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Remark::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Good',
        ];
    }
}
