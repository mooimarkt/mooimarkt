<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

trait ImageCropping
{
    public function saveCroppingImage($image, $options = [], $directory = 'tmp'){
        $img = Image::make($image);
        $img->rotate(-$options['rotate'] ?? 0);

        if (($options['width'] ?? 0) > 0 && ($options['height'] ?? 0) > 0) {
            $img->crop((int)$options['width'] ?? 0, (int)$options['height'] ?? 0, (int)$options['x'] ?? 0, (int)$options['y'] ?? 0);
        }
        if (is_object($image)) {
            $name = uniqid() . '_' . Str::camel($image->getClientOriginalName());
            Storage::put('public/uploads/'.$directory.'/'.$name, $img->encode()->encoded);

            $this->setThumb($name, Storage::disk('public')->path('uploads/'.$directory.'/thumbs/'), $img);

            return [
                'imagePath' => Storage::url('uploads/'.$directory.'/'.$name),
                'imageThumb' => Storage::url('uploads/'.$directory.'/thumbs/'.$name)
            ];
        }

        $img->save();
        $this->setThumb($img->basename, $img->dirname . '/thumbs/', $img);

        return [
            'imagePath' => $image,
            'imageThumb' => $img->dirname . '/thumbs/', $img
        ];
    }

    public function setThumb($name, $directory, $img)
    {
        $img->resize(180, null, function ( $constraint ) {
            $constraint->aspectRatio();
            $constraint->upsize();
        } )
            ->resize( null, 246, function ( $constraint ) {
                $constraint->aspectRatio();
                $constraint->upsize();
            } );

        if(!File::isDirectory($directory)){
            File::makeDirectory($directory, 0777, true, true);
        }
        $img->save($directory . $name);
    }

}
