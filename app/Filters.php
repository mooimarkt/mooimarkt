<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filters extends Model
{
	protected $table = 'sheet_filters';
	protected $primaryKey = 'id';
	protected $guarded = [];

	public function Data(){

		return $this->belongsTo('App\Filters', 'parentID');

	}
}
