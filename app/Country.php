<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    protected $table = 'countries';

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }
}
