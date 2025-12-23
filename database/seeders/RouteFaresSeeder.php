<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RouteFares;
use App\Models\CarDetails;
use App\Models\PickUpLocation;
use App\Models\DropLocation;

class RouteFaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $vehicles = CarDetails::pluck('id')->toArray();
        $pickupLocations = PickUpLocation::where('status', 'active')->pluck('id')->toArray();
        $dropoffLocations = DropLocation::where('status', 'active')->pluck('id')->toArray();

        if (empty($vehicles) || empty($pickupLocations) || empty($dropoffLocations)) {
            $this->command->warn('No vehicles, pickup locations, or dropoff locations found. Please seed these tables first.');
            return;
        }

        $this->command->info('Found vehicles: ' . implode(', ', $vehicles));
        $this->command->info('Found pickup locations: ' . implode(', ', $pickupLocations));
        $this->command->info('Found dropoff locations: ' . implode(', ', $dropoffLocations));

        // Sample route fares with unique combinations - only use existing vehicles
        $routeFares = [];
        
        // Create combinations only for vehicles that actually exist
        if (isset($vehicles[0])) {
            $routeFares[] = [
                'vehicle_id' => $vehicles[0],
                'pickup_id' => $pickupLocations[0],
                'dropoff_id' => $dropoffLocations[0],
                'amount' => 150.00,
                'start_date' => now()->subDays(30)->format('Y-m-d'),
                'end_date' => now()->addDays(30)->format('Y-m-d'),
                'status' => 'active',
            ];
        }
        
        if (isset($vehicles[0]) && isset($dropoffLocations[1])) {
            $routeFares[] = [
                'vehicle_id' => $vehicles[0],
                'pickup_id' => $pickupLocations[0],
                'dropoff_id' => $dropoffLocations[1],
                'amount' => 200.00,
                'start_date' => now()->subDays(30)->format('Y-m-d'),
                'end_date' => now()->addDays(60)->format('Y-m-d'),
                'status' => 'active',
            ];
        }
        
        if (isset($vehicles[0]) && isset($pickupLocations[1])) {
            $routeFares[] = [
                'vehicle_id' => $vehicles[0],
                'pickup_id' => $pickupLocations[1],
                'dropoff_id' => $dropoffLocations[0],
                'amount' => 180.00,
                'start_date' => now()->subDays(30)->format('Y-m-d'),
                'end_date' => now()->addDays(45)->format('Y-m-d'),
                'status' => 'active',
            ];
        }

        // Vehicle 2 combinations
        if (isset($vehicles[1])) {
            $routeFares[] = [
                'vehicle_id' => $vehicles[1],
                'pickup_id' => $pickupLocations[0],
                'dropoff_id' => $dropoffLocations[0],
                'amount' => 120.00,
                'start_date' => now()->subDays(30)->format('Y-m-d'),
                'end_date' => now()->addDays(90)->format('Y-m-d'),
                'status' => 'active',
            ];
        }
        
        if (isset($vehicles[1]) && isset($pickupLocations[1]) && isset($dropoffLocations[1])) {
            $routeFares[] = [
                'vehicle_id' => $vehicles[1],
                'pickup_id' => $pickupLocations[1],
                'dropoff_id' => $dropoffLocations[1],
                'amount' => 250.00,
                'start_date' => now()->subDays(30)->format('Y-m-d'),
                'end_date' => now()->addDays(120)->format('Y-m-d'),
                'status' => 'active',
            ];
        }

        // Insert route fares
        foreach ($routeFares as $routeFare) {
            // Check if this combination already exists
            $existing = RouteFares::where('vehicle_id', $routeFare['vehicle_id'])
                ->where('pickup_id', $routeFare['pickup_id'])
                ->where('dropoff_id', $routeFare['dropoff_id'])
                ->first();

            if (!$existing) {
                RouteFares::create($routeFare);
                $this->command->info("Route fare created: Vehicle {$routeFare['vehicle_id']}, Pickup {$routeFare['pickup_id']}, Dropoff {$routeFare['dropoff_id']}");
            } else {
                $this->command->info("Route fare already exists: Vehicle {$routeFare['vehicle_id']}, Pickup {$routeFare['pickup_id']}, Dropoff {$routeFare['dropoff_id']}");
            }
        }

        $this->command->info('RouteFares seeding completed!');
    }
}
