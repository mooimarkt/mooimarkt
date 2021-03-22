<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function subCategories() {
        return $this->hasMany('App\SubCategory', 'categoryId');
    }

    public function getSubCategoryId() {
        //return $this->hasMany('App\SubCategory', 'categoryId');
        return $this->hasMany('App\SubCategory','categoryId')->select(['id'])->get();
    }

    public function totalAdsCount() {
    	return \DB::table("ads")->whereIn("subCategoryId",$this->getSubCategoryId())
    				->where('adsStatus', '=',   'available')
    				     ->whereNull('ads.deleted_at')
                    ->where('ads.adsPlaceMethod', 'publish')
                    ->whereDate('ads.dueDate', ">",date("Y-m-d H:i:s"))
                    ->count();

    }

    function delete()
    {
        foreach($this->subCategories as $subCategory)
        {
            $subCategory->delete();
        }
        return parent::delete();
    }

}
