<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricing extends Model
{
    use SoftDeletes;

    protected $table = "pricing";
    protected $primaryKey = "id";
    protected $fillable = array('subCategoryId', 'type','price','data','offer_option');



    /*public function get_pricing_details(){
      return $this->hasMany('App\PricingDetails', 'packageID', 'id');
    }

    public function get_pricing_add_ons(){
      return $this->hasMany('App\PricingAddOns', 'packageID', 'id');
    }*/
}
