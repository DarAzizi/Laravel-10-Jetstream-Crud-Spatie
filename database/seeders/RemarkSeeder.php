<?php

namespace Database\Seeders;

use App\Models\Remark;
use Illuminate\Database\Seeder;

class RemarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Remark::factory()
            ->count(5)
            ->create();
    }
}
