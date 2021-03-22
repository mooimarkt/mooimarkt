<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimpleSave extends Model
{
	protected $table = "simple_save";
	protected $primaryKey = "id";
	protected $guarded = [];

	public function getSearchAttribute($value){

		return json_decode($value);

	}

	public function Category(){

		return $this->hasOne("App\Category","id","cid");

	}

	public function SubCategory(){

		return $this->hasOne("App\SubCategory","id","sid");

	}

	public function user(){

		return $this->hasOne("App\User","id","uid");

	}

}
