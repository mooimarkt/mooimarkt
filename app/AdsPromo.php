<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdsPromo extends Model
{
    use SoftDeletes;

    protected $table = "ads_promo";
    protected $primaryKey = "id";
    protected $fillable = array('adsId', 'promoType','promoDate');



    /*public function get_pricing_details(){
      return $this->hasMany('App\PricingDetails', 'packageID', 'id');
    }

    public function get_pricing_add_ons(){
      return $this->hasMany('App\PricingAddOns', 'packageID', 'id');
    }*/
}
