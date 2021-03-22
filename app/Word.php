<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Word extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if (Cache::has('word_' . $model->name)) {
                Cache::forget('word_' . $model->name);
            }
        });

        static::deleting(function ($model) {
            if (Cache::has('word_' . $model->name)) {
                Cache::forget('word_' . $model->name);
            }
        });
    }
}
