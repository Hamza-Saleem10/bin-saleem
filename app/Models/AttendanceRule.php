<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRule extends Model
{
    use HasFactory;
    protected $table = 'attendance_rules';
    
    protected $fillable = [
        'check_in_time',
        'check_out_time',
        'late_threshold',
        'location_radius',
        'allowed_locations',
        'is_active'
    ];
    
    protected $casts = [
        'allowed_locations' => 'array',
        'is_active' => 'boolean'
    ];
}
