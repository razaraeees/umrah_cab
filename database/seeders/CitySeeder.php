<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding cities...');

        $cities = [
            ['name' => 'Makkah', 'status' => true],
            ['name' => 'Madinah', 'status' => true],
            ['name' => 'Jeddah', 'status' => true],
            ['name' => 'Riyadh', 'status' => true],
            ['name' => 'Dammam', 'status' => true],
            ['name' => 'Taif', 'status' => true],
            ['name' => 'Yanbu', 'status' => true],
            ['name' => 'Abha', 'status' => true],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }

        $this->command->info('Cities seeded successfully!');
    }
}
