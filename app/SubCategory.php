<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    
    protected $table = 'sub_categories';
    protected $primaryKey = 'id';
    protected $guarded = [];

    function Category() {
        return $this->belongsTo(Category::class, 'categoryId');
    }
    public function totalAdsCount() {
    	return \DB::table("ads")->where("subCategoryId","=",$this->id)
    				->where('adsStatus', '=',   'available')
    				     ->whereNull('ads.deleted_at')
                    ->where('ads.adsPlaceMethod', 'publish')
                    ->whereDate('ads.dueDate', ">",date("Y-m-d H:i:s"))
                    ->count();
    }


    public function adsFilters()
    {
        return $this->hasMany(Filter::class);
    }

    public function filterType()
    {
        return $this->adsFilters->where('name', 'Type')->first();
    }

    public function ads()
    {
        return $this->hasMany(Ads::class, 'subCategoryId');
    }
}
