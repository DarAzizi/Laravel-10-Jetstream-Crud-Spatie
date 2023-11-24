<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->date(),
            'user_id' => \App\Models\User::factory(),
            'university_id' => \App\Models\University::factory(),
            'country_id' => \App\Models\Country::factory(),
            'city_id' => \App\Models\City::factory(),
            'graduation_id' => \App\Models\Graduation::factory(),
            'result_id' => \App\Models\Result::factory(),
            'remark_id' => \App\Models\Remark::factory(),
        ];
    }
}
