<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\HasBy;

class AttendanceLocation extends Model
{
    use HasUuid, HasBy, HasFactory;
    protected $table = 'attendance_locations';

    protected $fillable = [
        'uuid',
        'attendance_id',
        'latitude',
        'longitude',
        'location_name',
        'ip_address',
        'device_info',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
    
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

}
