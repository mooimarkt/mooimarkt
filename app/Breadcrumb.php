<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breadcrumb extends Model
{
    protected $guarded = [];
    function ads() {
        return $this->belongsTo('App\Ads', 'adsId');
    }
}
