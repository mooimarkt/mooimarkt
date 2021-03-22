<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormFieldOption extends Model
{   
    use SoftDeletes;
    
    protected $table = 'form_field_options';
    protected $primaryKey = 'id';
    //
}
