<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    public function ads()
    {
        return $this->belongsToMany(
            Ads::class,
            'ads_condition',
            'condition_id',
            'ads_id'
        );
    }
}
