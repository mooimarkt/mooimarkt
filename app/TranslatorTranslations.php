<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Eloquent\SoftDeletes;

class TranslatorTranslations extends Model
{
    //use SoftDeletes;
    
    protected $table = 'translator_translations';
    protected $primaryKey = 'id';

    public function addTranslation($group, $item){

    	$locales = DB::table('translator_languages')->get();

        foreach($locales as $locale){

            $exists = DB::table('translator_translations')
                        ->where('locale', $locale->locale)
                        ->where('group', $group)
                        ->where('item', $item)
                        ->select()->get();

            if(count($exists) <= 0){
                $translationData = new TranslatorTranslations;
                $translationData->locale = $locale->locale;
                $translationData->namespace = '*';
                $translationData->group = $group;
                $translationData->item = $item;
                $translationData->text = $item;
                $translationData->unstable = 0;
                $translationData->locked = 0;
                $translationData->save();
            }
        }
    }
}
