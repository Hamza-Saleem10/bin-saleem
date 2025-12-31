<?php

namespace App\Models;


use App\Traits\HasBy;
use App\Traits\HasUuid;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Vehicle extends Model implements HasMedia
{
    use HasBy, HasUuid, InteractsWithMedia;

    protected $fillable = [
        'uuid',
        'name',
        'seats',
        'bags_capacity',
        'features',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Define image conversions (e.g., a 'thumb' for the table)
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(70)
            ->nonQueued();
    }

    public function getImageUrlAttribute()
    {
        $media = $this->getFirstMedia('vehicles');
        return $media ? $media->getUrl('thumb') : asset('assets/images/default-car.jpg');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function routedetails()
    {
        return $this->hasMany(BookingsRouteDetail::class);
    }

}