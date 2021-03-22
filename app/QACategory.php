<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class QACategory extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    protected $fillable = ['title', 'image', 'description'];


    public function items()
    {
        return $this->hasMany(QAItem::class, 'q_a_category_id');
    }


}
