<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBy;
use App\Traits\HasUuid;

class Vehicle extends Model
{
    use HasBy, HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'seats',
        'bags-capacity',
        'features',
        'vehicle_image',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    // public function getFeaturesAttribute($value)
    // {
    //     return is_string($value) ? json_decode($value, true) : $value;
    // }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function routedetails()
    {
        return $this->hasMany(BookingsRouteDetail::class);
    }   
    // public function getImageUrlAttribute()
    // {
    //     return $this->image ? asset('storage/' . $this->image) : asset('assets/images/default-car.jpg');
    // }
}