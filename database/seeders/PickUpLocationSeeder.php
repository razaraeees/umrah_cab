<?php

namespace Database\Seeders;

use App\Models\PickUpLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PickUpLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            // Madina
            ['pickup_location' => 'Madina Airport', 'type' => 'Airport', 'status' => 'active'],
            ['pickup_location' => 'Madina Hotel', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Masjid Nabawi', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Quba Mosque', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Uhud Mountain', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Qiblatain Mosque', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Madina City Center', 'type' => 'City', 'status' => 'active'],
            
            // Makkah
            ['pickup_location' => 'Makkah Airport', 'type' => 'Airport', 'status' => 'active'],
            ['pickup_location' => 'Makkah Hotel', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Masjid Haram', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Haramain Train Station', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Mina', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Arafat', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Muzdalifah', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Makkah City Center', 'type' => 'City', 'status' => 'active'],
            
            // Riyadh
            ['pickup_location' => 'Riyadh Airport', 'type' => 'Airport', 'status' => 'active'],
            ['pickup_location' => 'Riyadh Hotel', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'King Saud Mosque', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Riyadh City Center', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Diriyah', 'type' => 'Ziyarat', 'status' => 'active'],
            
            // Jeddah
            ['pickup_location' => 'Jeddah Airport', 'type' => 'Airport', 'status' => 'active'],
            ['pickup_location' => 'Jeddah Hotel', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'King Abdulaziz Airport', 'type' => 'Airport', 'status' => 'active'],
            ['pickup_location' => 'Jeddah Corniche', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Al Balad', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Jeddah City Center', 'type' => 'City', 'status' => 'active'],
            
            // Dammam
            ['pickup_location' => 'Dammam Airport', 'type' => 'Airport', 'status' => 'active'],
            ['pickup_location' => 'Dammam Hotel', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Dammam Corniche', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Dammam City Center', 'type' => 'City', 'status' => 'active'],
            
            // Other Cities
            ['pickup_location' => 'Khobar', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Abha', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Tabuk', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Yanbu', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Taif', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Buraydah', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Hail', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Najran', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Jizan', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Arar', 'type' => 'City', 'status' => 'active'],
            ['pickup_location' => 'Sakakah', 'type' => 'City', 'status' => 'active'],
            
            // Additional Hotels
            ['pickup_location' => 'Movenpick Hotel Madina', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Hilton Madina', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'InterContinental Madina', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Movenpick Makkah', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Hilton Makkah', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'InterContinental Makkah', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Riyadh Marriott', 'type' => 'Hotel', 'status' => 'active'],
            ['pickup_location' => 'Jeddah Marriott', 'type' => 'Hotel', 'status' => 'active'],
            
            // Additional Ziyarat Places
            ['pickup_location' => 'Jannat al Baqi', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Masjid Qiblatain', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Masjid Jummah', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Masjid Ali', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Masjid Abu Bakr', 'type' => 'Ziyarat', 'status' => 'active'],
            ['pickup_location' => 'Masjid Umar', 'type' => 'Ziyarat', 'status' => 'active'],
            
            // Guide Services
            ['pickup_location' => 'Ziyarat Guide Madina', 'type' => 'Guide', 'status' => 'active'],
            ['pickup_location' => 'Ziyarat Guide Makkah', 'type' => 'Guide', 'status' => 'active'],
            ['pickup_location' => 'Tour Guide Riyadh', 'type' => 'Guide', 'status' => 'active'],
            ['pickup_location' => 'Tour Guide Jeddah', 'type' => 'Guide', 'status' => 'active'],
        ];

        foreach ($locations as $location) {
            PickUpLocation::create($location);
        }
    }
}
