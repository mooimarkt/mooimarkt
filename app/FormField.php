<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use SoftDeletes;
    
    protected $table = 'form_fields';
    protected $primaryKey = 'id';


}
