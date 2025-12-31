<?php

namespace App\Models;

use App\Traits\HasBy;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasBy, HasUuid;
    protected $fillable = ['uuid', 'author', 'location', 'rating', 'booking_reference','route_detail', 'travel_date', 'comment', 'is_active', 'created_by', 'updated_by'];
}
