<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SubCategoryField extends Model
{
    use SoftDeletes;
    
    protected $table = 'subCategory_fields';
    protected $primaryKey = 'id';

    public function subCategoryFieldFormField(){

        $form = DB::table('subCategory_fields')
                    ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                    ->whereNull('subCategory_fields.deleted_at')
                    ->whereNull('form_fields.deleted_at')
                    ->orderBy('form_fields.sort', 'desc')
                    ->orderBy('form_fields.fieldTitle', 'asc')
                    ->get();

        return $form;
    }
}
