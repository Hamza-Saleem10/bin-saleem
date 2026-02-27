<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasBy;
use Illuminate\Database\Eloquent\Model;

class BookingsRouteDetail extends Model
{
    use HasBy, HasUuid;
    protected $table = 'bookings_route_details';

    protected $fillable = [
        'uuid',
        'booking_id',
        'route_id',
        'pickup_date',
        'pickup_time',
        'vehicle_id',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'pickup_date' => 'date',
        'pickup_time' => 'datetime',
    ];
    
    public function getRouteNameAttribute()
    {
        if ($this->route) {
            return $this->route->from_location . ' To ' . $this->route->to_location;
        }

        return 'N/A';
    }

    // Relationship back to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
}
