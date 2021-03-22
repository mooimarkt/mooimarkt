<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class Option extends Model {

	public $timestamps = true;

	protected $table = 'options';
	protected $primaryKey = 'ID';
	protected $fillable = array( 'name', 'value','entity_id','entity_type' );

	public static function getSetting($name, $default = ''){
		$opt = Option::where('name',$name)
		             ->where('entity_type','settings')
		             ->where('entity_id',0)->first();

		return $opt ? $opt->value : $default;
	}

	public static function setSetting($name, $val){

		$opt = Option::where('name', $name)
		             ->where('entity_type','settings')
		             ->where('entity_id',0)->first();

		$opt = is_null($opt) ? new Option() : $opt;

		$opt->name  =  $name;
		$opt->value =  is_array($val) ? json_encode($val) : $val;
		$opt->entity_type =  "settings";
		$opt->entity_id =  0;
		$opt->save();

		return true;
	}

    public static function uploadSlider($image)
    {
        $ext = $image->getClientOriginalExtension();
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {

            $name = uniqid(Auth::user()->id . '_') . "." . $image->getClientOriginalExtension();
            /*Storage::putFileAs('/public/uploads/slider/', $image, $name);*/

            $preview    = Image::make($image)
                ->resize(1110, 430); // resize the image to a width of 740 and constrain aspect ratio (auto height)
            $folder     = config('image.folder').'slider/'; // save to folder
            $path       = public_path($folder); // full path for saving
            if (!file_exists($path)) mkdir($path, 0775, true); // create dir if not exist
            $preview->save($path.$name); // save resized image

            return Storage::url('uploads/slider/' . $name);
        } else {
            return false;
        }
    }

    public static function existsSlideImage($image) {
	    if (isset($image) && !empty($image) && File::exists(trim($image, '/'))) {
            return true;
        }
	    return false;
    }

    public static function getCost($type){
	    if (floatval(Option::getSetting($type)) >= 1) {
	        return [
	            'cost' => floatval(Option::getSetting($type)),
                'currency' => 'dollars'
            ];
        }
	    else {
            return [
                'cost' => floatval(Option::getSetting($type)) * 100,
                'currency' => 'cents'
            ];
        }
    }

}

