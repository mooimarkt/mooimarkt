<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SearchCriteria extends Model
{
    use SoftDeletes;
    
    protected $table = "search_criteria";
    protected $primaryKey = "id";
}
