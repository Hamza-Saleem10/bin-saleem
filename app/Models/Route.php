<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBy;
use App\Traits\HasUuid;

class Route extends Model
{
    use HasUuid, HasBy;
    protected $fillable = [
        'uuid',
        'from_location',
        'to_location',
        'is_active',
        'created_by',
        'updated_by',
    ];
    
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

}
