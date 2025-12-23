<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding drivers...');

        $drivers = [
            [
                'name' => 'Ahmed Muhammad',
                'phone' => '+966501234567',
                'email' => 'ahmed.driver@umrah.com',
                'status' => 'active',
                'car_id' => 1, // Toyota Camry
                'rc_copy' => 'rc_ahmed.pdf',
                'driving_license' => 'dl_ahmed.pdf',
                'dl_expiry' => now()->addYears(3)->format('Y-m-d'),
                'insurance_copy' => 'insurance_ahmed.pdf',
                'car_image' => 'camry_ahmed.jpg',
                'driver_image' => 'driver_ahmed.jpg',
            ],
            [
                'name' => 'Mohammed Ali',
                'phone' => '+966502345678',
                'email' => 'mohammed.driver@umrah.com',
                'status' => 'active',
                'car_id' => 2, // Honda Accord
                'rc_copy' => 'rc_mohammed.pdf',
                'driving_license' => 'dl_mohammed.pdf',
                'dl_expiry' => now()->addYears(2)->format('Y-m-d'),
                'insurance_copy' => 'insurance_mohammed.pdf',
                'car_image' => 'accord_mohammed.jpg',
                'driver_image' => 'driver_mohammed.jpg',
            ],
            [
                'name' => 'Abdullah Rahman',
                'phone' => '+966503456789',
                'email' => 'abdullah.driver@umrah.com',
                'status' => 'active',
                'car_id' => 3, // Toyota Hiace
                'rc_copy' => 'rc_abdullah.pdf',
                'driving_license' => 'dl_abdullah.pdf',
                'dl_expiry' => now()->addYears(4)->format('Y-m-d'),
                'insurance_copy' => 'insurance_abdullah.pdf',
                'car_image' => 'hiace_abdullah.jpg',
                'driver_image' => 'driver_abdullah.jpg',
            ],
            [
                'name' => 'Khalid Omar',
                'phone' => '+966504567890',
                'email' => 'khalid.driver@umrah.com',
                'status' => 'active',
                'car_id' => 4, // Nissan Patrol
                'rc_copy' => 'rc_khalid.pdf',
                'driving_license' => 'dl_khalid.pdf',
                'dl_expiry' => now()->addYears(3)->format('Y-m-d'),
                'insurance_copy' => 'insurance_khalid.pdf',
                'car_image' => 'patrol_khalid.jpg',
                'driver_image' => 'driver_khalid.jpg',
            ],
            [
                'name' => 'Saeed Hassan',
                'phone' => '+966505678901',
                'email' => 'saeed.driver@umrah.com',
                'status' => 'active',
                'car_id' => 5, // Toyota Land Cruiser
                'rc_copy' => 'rc_saeed.pdf',
                'driving_license' => 'dl_saeed.pdf',
                'dl_expiry' => now()->addYears(5)->format('Y-m-d'),
                'insurance_copy' => 'insurance_saeed.pdf',
                'car_image' => 'landcruiser_saeed.jpg',
                'driver_image' => 'driver_saeed.jpg',
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }

        $this->command->info('Drivers seeded successfully!');
    }
}