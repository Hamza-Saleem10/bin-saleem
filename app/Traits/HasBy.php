<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasBy
{
    /**
     * boot
     */
    protected static function bootHasBy()
    {
        $userId = Auth::id();

        static::creating(function ($model) use ($userId) {
            $model->created_by = $userId;
            $model->created_at = now();
        });

        static::updating(function ($model) use ($userId) {
            $model->updated_by = $userId;
            $model->updated_at = now();
        });
    }
}