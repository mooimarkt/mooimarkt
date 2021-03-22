<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedUsers extends Model
{
    protected $table = "saved_users";
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
