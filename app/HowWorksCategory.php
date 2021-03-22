<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HowWorksCategory extends Model
{
    public function items()
    {
        return $this->hasMany(HowWorksItem::class, 'how_works_category_id');
    }
}
