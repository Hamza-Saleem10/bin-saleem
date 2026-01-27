<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBy;
use App\Traits\HasUuid;

class AttendanceRule extends Model
{
    use HasFactory, HasUuid, HasBy;
    protected $table = 'attendance_rules';
    
    protected $fillable = [
        'uuid',
        'name',
        'check_in_time',
        'check_out_time',
        'late_threshold',
        'location_radius',
        'allowed_locations',
        'is_active',
        'created_by',
        'updated_by'
    ];
    
    protected $casts = [
        'allowed_locations' => 'array',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    
    // Relationship with users
    public function users()
    {
        return $this->hasMany(User::class, 'attendance_rule_id');
    }
}
