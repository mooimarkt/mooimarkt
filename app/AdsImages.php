<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdsImages extends Model
{
    protected $table = 'adsImages';
    protected $guarded = [];
    function delete()
    {
    	File::delete(public_path($this->imagePath));
        parent::delete();
    }

    public function getThumbAttribute() {
        return empty($this->imagePath_thumb) ? $this->imagePath : $this->imagePath_thumb;
    }

    public function getNameImage()
    {
        $arrayPath = explode('/', $this->imagePath);

        return array_pop($arrayPath);
    }

    public function getSizeImage()
    {
        if(File::exists(public_path($this->imagePath))) {
            $size = File::size(public_path($this->imagePath));

            return $this->formatBytes($size);
        }
        return;
    }

    public function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('', 'kb', 'mb', 'G');

        return [ 'size' => round(pow(1024, $base - floor($base)), $precision), 'suffix' => $suffixes[floor($base)]];
    }
}
