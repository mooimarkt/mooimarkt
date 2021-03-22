<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterValues extends Model
{
	protected $table = 'new_filter_values';
	protected $primaryKey = 'id';
	protected $guarded = [];

	public function name(){

		return $this->hasOne('App\FilterNames','id','filter_id');

	}
}
