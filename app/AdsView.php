<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdsView extends Model
{
    use SoftDeletes;
    
    protected $table = 'ads_view';
    protected $primaryKey = 'id';
}
