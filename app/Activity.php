<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function ads() {
        return $this->belongsTo('App\Ads');
    }

    public function buyer() {
        return $this->belongsTo('App\User');
    }

    public function seller() {
        return $this->belongsTo('App\User');
    }
}

