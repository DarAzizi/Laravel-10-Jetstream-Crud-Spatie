<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(BookSeeder::class);
        $this->call(CertificateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(GraduationSeeder::class);
        $this->call(RemarkSeeder::class);
        $this->call(ResultSeeder::class);
        $this->call(UniversitySeeder::class);
        $this->call(UserSeeder::class);
    }
}
