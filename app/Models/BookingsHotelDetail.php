<?php

namespace App\Models;

use App\Traits\HasBy;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class BookingsHotelDetail extends Model
{
    use HasUuid, Hasby;
    protected $table = 'bookings_hotel_details';

    protected $fillable = [
        'uuid',
        'booking_id',
        'city',
        'hotel_name',
        'check_in_date',
        'check_out_date',
        'duration',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'duration' => 'integer',
    ];
    
    public function booking()
    {
        return $this->belongsTo(Booking::class,'booking_id');
    }

}
