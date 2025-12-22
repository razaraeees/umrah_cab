<?php

namespace Database\Seeders;

use App\Models\DropLocation;
use App\Models\PickUpLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DropOffLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pickupLocations = PickUpLocation::all();
        
        // Fixed dropoff locations with unique names but can have same pickup_id
        $dropoffLocations = [
            // Madina dropoffs (use pickup names to get IDs)
            ['pickup_name' => 'Madina Airport', 'dropoff' => 'Madina Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Madina Airport', 'dropoff' => 'Masjid Nabawi', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Madina Airport', 'dropoff' => 'Quba Mosque', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Madina Airport', 'dropoff' => 'Madina City Center', 'type' => 'City'],
            ['pickup_name' => 'Madina Airport', 'dropoff' => 'Uhud Mountain', 'type' => 'Ziyarat'],
            
            ['pickup_name' => 'Madina Hotel', 'dropoff' => 'Masjid Nabawi', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Madina Hotel', 'dropoff' => 'Quba Mosque', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Madina Hotel', 'dropoff' => 'Madina Airport', 'type' => 'Airport'],
            ['pickup_name' => 'Madina Hotel', 'dropoff' => 'Madina City Center', 'type' => 'City'],
            
            ['pickup_name' => 'Masjid Nabawi', 'dropoff' => 'Madina Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Masjid Nabawi', 'dropoff' => 'Quba Mosque', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Masjid Nabawi', 'dropoff' => 'Uhud Mountain', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Masjid Nabawi', 'dropoff' => 'Madina City Center', 'type' => 'City'],
            
            ['pickup_name' => 'Quba Mosque', 'dropoff' => 'Masjid Nabawi', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Quba Mosque', 'dropoff' => 'Madina Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Quba Mosque', 'dropoff' => 'Madina City Center', 'type' => 'City'],
            
            ['pickup_name' => 'Uhud Mountain', 'dropoff' => 'Masjid Nabawi', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Uhud Mountain', 'dropoff' => 'Madina Hotel', 'type' => 'Hotel'],
            
            // Makkah dropoffs
            ['pickup_name' => 'Makkah Airport', 'dropoff' => 'Makkah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Makkah Airport', 'dropoff' => 'Masjid Haram', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Makkah Airport', 'dropoff' => 'Haramain Train Station', 'type' => 'City'],
            ['pickup_name' => 'Makkah Airport', 'dropoff' => 'Makkah City Center', 'type' => 'City'],
            ['pickup_name' => 'Makkah Airport', 'dropoff' => 'Mina', 'type' => 'Ziyarat'],
            
            ['pickup_name' => 'Makkah Hotel', 'dropoff' => 'Masjid Haram', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Makkah Hotel', 'dropoff' => 'Haramain Train Station', 'type' => 'City'],
            ['pickup_name' => 'Makkah Hotel', 'dropoff' => 'Makkah Airport', 'type' => 'Airport'],
            ['pickup_name' => 'Makkah Hotel', 'dropoff' => 'Makkah City Center', 'type' => 'City'],
            
            ['pickup_name' => 'Masjid Haram', 'dropoff' => 'Makkah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Masjid Haram', 'dropoff' => 'Haramain Train Station', 'type' => 'City'],
            ['pickup_name' => 'Masjid Haram', 'dropoff' => 'Mina', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Masjid Haram', 'dropoff' => 'Arafat', 'type' => 'Ziyarat'],
            
            ['pickup_name' => 'Haramain Train Station', 'dropoff' => 'Makkah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Haramain Train Station', 'dropoff' => 'Masjid Haram', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Haramain Train Station', 'dropoff' => 'Makkah City Center', 'type' => 'City'],
            
            // Riyadh dropoffs
            ['pickup_name' => 'Riyadh Airport', 'dropoff' => 'Riyadh Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Riyadh Airport', 'dropoff' => 'King Saud Mosque', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Riyadh Airport', 'dropoff' => 'Riyadh City Center', 'type' => 'City'],
            ['pickup_name' => 'Riyadh Airport', 'dropoff' => 'Diriyah', 'type' => 'Ziyarat'],
            
            ['pickup_name' => 'Riyadh Hotel', 'dropoff' => 'King Saud Mosque', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Riyadh Hotel', 'dropoff' => 'Riyadh City Center', 'type' => 'City'],
            ['pickup_name' => 'Riyadh Hotel', 'dropoff' => 'Diriyah', 'type' => 'Ziyarat'],
            
            ['pickup_name' => 'King Saud Mosque', 'dropoff' => 'Riyadh Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'King Saud Mosque', 'dropoff' => 'Riyadh City Center', 'type' => 'City'],
            
            // Jeddah dropoffs
            ['pickup_name' => 'Jeddah Airport', 'dropoff' => 'Jeddah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Jeddah Airport', 'dropoff' => 'Jeddah Corniche', 'type' => 'City'],
            ['pickup_name' => 'Jeddah Airport', 'dropoff' => 'Al Balad', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Jeddah Airport', 'dropoff' => 'Jeddah City Center', 'type' => 'City'],
            
            ['pickup_name' => 'Jeddah Hotel', 'dropoff' => 'Jeddah Corniche', 'type' => 'City'],
            ['pickup_name' => 'Jeddah Hotel', 'dropoff' => 'Al Balad', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Jeddah Hotel', 'dropoff' => 'Jeddah City Center', 'type' => 'City'],
            
            ['pickup_name' => 'Jeddah Corniche', 'dropoff' => 'Jeddah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Jeddah Corniche', 'dropoff' => 'Al Balad', 'type' => 'Ziyarat'],
            
            // Dammam dropoffs
            ['pickup_name' => 'Dammam Airport', 'dropoff' => 'Dammam Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Dammam Airport', 'dropoff' => 'Dammam Corniche', 'type' => 'City'],
            ['pickup_name' => 'Dammam Airport', 'dropoff' => 'Dammam City Center', 'type' => 'City'],
            ['pickup_name' => 'Dammam Airport', 'dropoff' => 'Khobar', 'type' => 'City'],
            
            ['pickup_name' => 'Dammam Hotel', 'dropoff' => 'Dammam Corniche', 'type' => 'City'],
            ['pickup_name' => 'Dammam Hotel', 'dropoff' => 'Dammam City Center', 'type' => 'City'],
            ['pickup_name' => 'Dammam Hotel', 'dropoff' => 'Khobar', 'type' => 'City'],
            
            // Additional cross-city connections
            ['pickup_name' => 'Madina Airport', 'dropoff' => 'Makkah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Makkah Airport', 'dropoff' => 'Madina Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Riyadh Airport', 'dropoff' => 'Jeddah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Jeddah Airport', 'dropoff' => 'Riyadh Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Dammam Airport', 'dropoff' => 'Riyadh Hotel', 'type' => 'Hotel'],
            
            // More Madina variations
            ['pickup_name' => 'Madina City Center', 'dropoff' => 'Masjid Nabawi', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Madina City Center', 'dropoff' => 'Quba Mosque', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Madina City Center', 'dropoff' => 'Madina Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Madina City Center', 'dropoff' => 'Uhud Mountain', 'type' => 'Ziyarat'],
            
            // More Makkah variations
            ['pickup_name' => 'Makkah City Center', 'dropoff' => 'Masjid Haram', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Makkah City Center', 'dropoff' => 'Makkah Hotel', 'type' => 'Hotel'],
            ['pickup_name' => 'Makkah City Center', 'dropoff' => 'Haramain Train Station', 'type' => 'City'],
            ['pickup_name' => 'Makkah City Center', 'dropoff' => 'Mina', 'type' => 'Ziyarat'],
            
            // Guide services
            ['pickup_name' => 'Ziyarat Guide Madina', 'dropoff' => 'Masjid Nabawi', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Ziyarat Guide Madina', 'dropoff' => 'Quba Mosque', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Ziyarat Guide Makkah', 'dropoff' => 'Masjid Haram', 'type' => 'Ziyarat'],
            ['pickup_name' => 'Ziyarat Guide Makkah', 'dropoff' => 'Mina', 'type' => 'Ziyarat'],
        ];
        
        // Create dropoff locations with unique names
        foreach ($dropoffLocations as $dropoff) {
            // Find pickup location by name and get its ID from model
            $pickup = $pickupLocations->where('pickup_location', $dropoff['pickup_name'])->first();
            
            if ($pickup) {
                DropLocation::create([
                    'pick_up_location_id' => $pickup->id, // Get ID from model
                    'drop_off_location' => $dropoff['dropoff'],
                    'type' => $dropoff['type'],
                    'status' => 'active',
                ]);
            }
        }
    }
}
