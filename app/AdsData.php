<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdsData extends Model
{
    use SoftDeletes;
    
    protected $table = 'ads_datas';
    protected $primaryKey = 'id';
}
