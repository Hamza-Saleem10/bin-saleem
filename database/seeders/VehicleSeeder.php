<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        Vehicle::upsert([
            [
                'name' => 'Toyota Camry',
                'seats' => 4,
                'bags_capacity' => 2,
                'features' => json_encode(['WiFi', 'AC']),
                'vehicle_image' => 'vehicles/camry.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'GMC Yukon',
                'seats' => 7,
                'bags_capacity' => 4,
                'features' => json_encode(['AC Chilled', 'Premium Interior']),
                'vehicle_image' => 'vehicles/gmc.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Toyota Innova',
                'seats' => 7,
                'bags_capacity' => 5,
                'features' => json_encode(['Child Seat', 'Spacious']),
                'vehicle_image' => 'vehicles/innova.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Toyota HiAce',
                'seats' => 10,
                'bags_capacity' => 10,
                'features' => json_encode(['Group Travel', 'Extra Legroom']),
                'vehicle_image' => 'vehicles/hiace.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Hyundai Staria',
                'seats' => 8,
                'bags_capacity' => 8,
                'features' => json_encode(['Panoramic Roof', 'Premium Interior']),
                'vehicle_image' => 'vehicles/staria.jpg',
                'is_active' => true,
            ],
        ], 
        ['name'], // Unique column for identifying duplicates
        ['seats', 'bags_capacity', 'features', 'vehicle_image', 'is_active'] // Columns to update if duplicate exists
        );
    }
}