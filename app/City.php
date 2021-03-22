<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
