<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarDetails;

class CarDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding car details...');

        $cars = [
            [
                'name' => 'Toyota Camry',
                'model_variant' => 'LE 2023',
                'color' => 'White',
                'door' => '4',
                'bag_capacity' => '3',
                'registration_number' => 'UMRAH-001',
                'year' => 2023,
                'seating_capacity' => 4,
                'fuel_type' => 'Petrol',
                'car_type' => 'Sedan',
                'air_condition' => true,
            ],
            [
                'name' => 'Honda Accord',
                'model_variant' => 'EX 2023',
                'color' => 'Black',
                'door' => '4',
                'bag_capacity' => '4',
                'registration_number' => 'UMRAH-002',
                'year' => 2023,
                'seating_capacity' => 5,
                'fuel_type' => 'Petrol',
                'car_type' => 'Sedan',
                'air_condition' => true,
            ],
            [
                'name' => 'Toyota Hiace',
                'model_variant' => 'Van 2023',
                'color' => 'Silver',
                'door' => '4',
                'bag_capacity' => '8',
                'registration_number' => 'UMRAH-003',
                'year' => 2023,
                'seating_capacity' => 7,
                'fuel_type' => 'Diesel',
                'car_type' => 'Van',
                'air_condition' => true,
            ],
            [
                'name' => 'Nissan Patrol',
                'model_variant' => 'SUV 2023',
                'color' => 'Gold',
                'door' => '4',
                'bag_capacity' => '6',
                'registration_number' => 'UMRAH-004',
                'year' => 2023,
                'seating_capacity' => 7,
                'fuel_type' => 'Petrol',
                'car_type' => 'SUV',
                'air_condition' => true,
            ],
            [
                'name' => 'Toyota Land Cruiser',
                'model_variant' => 'VXR 2023',
                'color' => 'Pearl White',
                'door' => '4',
                'bag_capacity' => '7',
                'registration_number' => 'UMRAH-005',
                'year' => 2023,
                'seating_capacity' => 8,
                'fuel_type' => 'Petrol',
                'car_type' => 'SUV',
                'air_condition' => true,
            ],
        ];

        foreach ($cars as $car) {
            CarDetails::create($car);
        }

        $this->command->info('Car details seeded successfully!');
    }
}
