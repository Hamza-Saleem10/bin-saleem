<?php

namespace App\Models;

use App\Traits\HasBy;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasUuid, HasBy;
    protected $fillable = [
        'uuid',
        'customer_name',
        'customer_email',
        'customer_contact',
        'adult_person',
        'child_person',
        'infant_person',
        'number_of_pax',
        'status',
        'is_active',
        'created_by',   
        'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    
    // public function vehicle(){
    //     return $this->belongsTo(Vehicle::class);
    // }
    // Relationship with Hotel Details (One-to-Many)
    public function hotelDetails()
    {
        return $this->hasMany(BookingsHotelDetail::class,'booking_id');
    }
    
    // Relationship with Flight Details (One-to-Many)
    public function flightDetails()
    {
        return $this->hasMany(BookingsFlightDetail::class);
    }
    
    // Relationship with Route Details (One-to-Many)
    public function routeDetails()
    {
        return $this->hasMany(BookingsRouteDetail::class);
    }
}
