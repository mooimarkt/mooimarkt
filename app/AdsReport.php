<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdsReport extends Model
{
    use SoftDeletes;
    
    protected $table = 'adsReport';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Ad(){

    	return $this->hasOne("App\Ads",'id','adsId');

    }
}
