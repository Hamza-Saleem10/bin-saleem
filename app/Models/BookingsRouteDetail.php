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
        'pick_up',
        'pickup_date',
        'pickup_time',
        'vehicle_id',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'pickup_date' => 'date',
    ];
    
    // Relationship back to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }
}
