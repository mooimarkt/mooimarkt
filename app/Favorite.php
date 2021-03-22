<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	protected $guarded = [];

    public function favoritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
