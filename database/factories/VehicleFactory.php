<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Toyota Camry', 'GMC Yukon', 'Toyota Innova', 'Toyota HiAce', 'Hyundai Staria'
            ]),
            'seats' => $this->faker->randomElement([4, 7, 8, 10]),
            'bags' => $this->faker->numberBetween(2, 10),
            'features' => $this->faker->randomElements(
                ['WiFi', 'AC', 'Child Seat', 'Panoramic Roof', 'Premium Interior', 'Extra Legroom'],
                $this->faker->numberBetween(1, 4)
            ),
            'image' => null,
            'is_active' => true,
        ];
    }
}