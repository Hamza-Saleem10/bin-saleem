<?php

namespace App\Models;

use App\Traits\HasBy;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class BookingsFlightDetail extends Model
{
    use Hasby, HasUuid;
    protected $table = 'bookings_flight_details';

    protected $fillable = [
        'uuid',
        'booking_id',
        'flight_code',
        'flight_from',
        'flight_to',
        'flight_date',
        'departure_time',
        'arrival_time',
        'created_by',
        'updated_by',
    ];

    // Relationship back to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
