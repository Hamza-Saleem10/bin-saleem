<?php

namespace App\Models;

use App\Traits\HasBy;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasUuid, HasBy, HasFactory;
    protected $fillable = [
        'uuid',
        'voucher_number',
        'customer_name',
        'customer_email',
        'customer_contact',
        'booking_by',
        'adult_person',
        'child_person',
        'infant_person',
        'number_of_pax',
        // 'date_field_name',
        'status',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->voucher_number)) {
                $booking->voucher_number = self::generateVoucherNumber();
            }
        });
    }

    public static function generateVoucherNumber()
    {
        // Get the last voucher number
        $lastBooking = self::where('voucher_number', 'like', 'BST-%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastBooking) {
            // Extract numeric part
            preg_match('/BST-(\d+)/', $lastBooking->voucher_number, $matches);
            $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        } else {
            $nextNumber = 1;
        }

        // Format: BST-0001, BST-0002, etc.
        return 'BST-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booking_by');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    // Relationship with Hotel Details (One-to-Many)
    public function hotelDetails()
    {
        return $this->hasMany(BookingsHotelDetail::class, 'booking_id');
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
