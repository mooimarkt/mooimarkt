<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    public function ads()
    {
        return $this->belongsToMany(
            Ads::class,
            'ads_size',
            'size_id',
            'ads_id'
        );
    }
}
