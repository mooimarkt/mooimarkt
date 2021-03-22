<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HowWorksItem extends Model
{
    public function category()
    {
        return $this->belongsTo(HowWorksCategory::class, 'how_works_category_id');
    }
}
