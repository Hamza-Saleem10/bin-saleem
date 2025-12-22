<?php

namespace App\Models;

use App\Traits\HasBy;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasBy, HasUuid;
    protected $fillable = ['uuid', 'author', 'location', 'comment', 'rating', 'booking_reference', 'is_active', 'created_by', 'updated_by'];
}
