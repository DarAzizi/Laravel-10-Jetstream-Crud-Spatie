<?php

namespace Database\Seeders;

use App\Models\Graduation;
use Illuminate\Database\Seeder;

class GraduationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Graduation::factory()
            ->count(5)
            ->create();
    }
}
