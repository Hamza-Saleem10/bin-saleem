<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Traits\HasBy;

class Attendance extends Model
{
    use HasUuid, HasBy, HasFactory;
    protected $table = 'attendance';

    protected $fillable = [
        'uuid',
        'user_id',
        'date',
        'check_in',
        'check_out',
        'total_working_days',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function location()
    {
        return $this->hasOne(AttendanceLocation::class, 'attendance_id');
    }
}
