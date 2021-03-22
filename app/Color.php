<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function ads()
    {
        return $this->belongsToMany(
            Ads::class,
            'ads_color',
            'color_id',
            'ads_id'
        );
    }
}
