<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QAItem extends Model
{
    public function category()
    {
        return $this->belongsTo(QACategory::class, 'q_a_category_id');
    }
}
