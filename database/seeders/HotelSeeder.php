<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\City;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding hotels...');

        // Get all cities to use their IDs
        $cities = City::all();
        
        if ($cities->isEmpty()) {
            $this->command->error('No cities found! Please run CitySeeder first.');
            return;
        }

        $hotels = [
            ['name' => 'Hilton Makkah', 'city_id' => $cities->where('name', 'Makkah')->first()->id, 'status' => true],
            ['name' => 'Makkah Royal Clock Tower', 'city_id' => $cities->where('name', 'Makkah')->first()->id, 'status' => true],
            ['name' => 'Pullman Zamzam Makkah', 'city_id' => $cities->where('name', 'Makkah')->first()->id, 'status' => true],
            ['name' => 'Anwar Al Madinah', 'city_id' => $cities->where('name', 'Madinah')->first()->id, 'status' => true],
            ['name' => 'The Madinah Hilton', 'city_id' => $cities->where('name', 'Madinah')->first()->id, 'status' => true],
            ['name' => 'Dar Al Taqwa', 'city_id' => $cities->where('name', 'Madinah')->first()->id, 'status' => true],
            ['name' => 'Jeddah Hilton', 'city_id' => $cities->where('name', 'Jeddah')->first()->id, 'status' => true],
            ['name' => 'Rosewood Jeddah', 'city_id' => $cities->where('name', 'Jeddah')->first()->id, 'status' => true],
            ['name' => 'Riyadh Marriott', 'city_id' => $cities->where('name', 'Riyadh')->first()->id, 'status' => true],
            ['name' => 'Four Seasons Riyadh', 'city_id' => $cities->where('name', 'Riyadh')->first()->id, 'status' => true],
            ['name' => 'Dammam Sheraton', 'city_id' => $cities->where('name', 'Dammam')->first()->id, 'status' => true],
            ['name' => 'Golden Tulip Dammam', 'city_id' => $cities->where('name', 'Dammam')->first()->id, 'status' => true],
            ['name' => 'Taif Rose Hotel', 'city_id' => $cities->where('name', 'Taif')->first()->id, 'status' => true],
            ['name' => 'InterContinental Taif', 'city_id' => $cities->where('name', 'Taif')->first()->id, 'status' => true],
            ['name' => 'Yanbu Beach Resort', 'city_id' => $cities->where('name', 'Yanbu')->first()->id, 'status' => true],
            ['name' => 'Movenpick Yanbu', 'city_id' => $cities->where('name', 'Yanbu')->first()->id, 'status' => true],
            ['name' => 'Abha Palace Hotel', 'city_id' => $cities->where('name', 'Abha')->first()->id, 'status' => true],
            ['name' => 'Bustan Abha', 'city_id' => $cities->where('name', 'Abha')->first()->id, 'status' => true],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }

        $this->command->info('Hotels seeded successfully!');
    }
}
