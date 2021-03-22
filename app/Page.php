<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected 	$primaryKey = 'page'; // or null
    public 		$incrementing = false;
    protected 	$guarded = [];

    public function delete()
    {
    	$this->update(['status' => 'deleted']);
    	// parent::delete();
    }
}
