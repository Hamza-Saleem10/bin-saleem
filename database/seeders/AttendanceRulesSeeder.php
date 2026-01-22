<?php

namespace Database\Seeders;

use App\Models\AttendanceRule;
use Illuminate\Database\Seeder;

class AttendanceRulesSeeder extends Seeder
{
    public function run()
    {
        AttendanceRule::create([
            'check_in_time' => '09:00:00',
            'check_out_time' => '17:00:00',
            'late_threshold' => 15,
            'location_radius' => 100,
            'is_active' => true
        ]);
    }
}