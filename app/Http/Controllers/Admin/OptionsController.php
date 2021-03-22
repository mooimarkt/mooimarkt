<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Option;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OptionsController extends BaseController {

	public function save(Request $request){
		$errors = [];
		foreach ($request->except('opt_slider') as $key => $val){
			if(strpos($key,'opt_') === 0){
				try{
					Option::setSetting($key, $val);
				}catch (\Exception $e){
					$errors[] = $e->getMessage();
				}
			}
		}

		if($request->opt_slider != null) {
            $slider = [];
            foreach ($request->opt_slider as $slide) {
                $slider[] = [
                    'slider_content' => $slide['slider_content'],
                    'url_link' => isset($slide['url_link']) ? $slide['url_link'] : '',
                    'url_name' => isset($slide['url_name']) ? $slide['url_name'] : '',
                    'image_url' => isset($slide['image_url']) ? Option::uploadSlider($slide['image_url']) : $slide['text_image_url'] ?? '',
                ];
            };
            Option::setSetting('opt_slider', json_encode($slider));
        }

        return count($errors) > 0 ? redirect()->back()->withErrors($errors) : redirect()->back();

	}

	public function upload(Request $request){

		$errors = [];

		foreach ($request->all() as $key => $val){

			if(strpos($key,'opt_') === 0){

				try{

					$file 		= Input::file($key)->openFile();
					$content 	= $file->fread($file->getSize());

					Option::setSetting($key,$content);

				}catch (\Exception $e){

					$errors[] = $e->getMessage();

				}

			}


		}

		return count($errors) > 0 ? redirect()->back()->withErrors($errors) : redirect()->back();
	}

    public function deleteSlider(Request $request)
    {
        if ($request->imageName != null) {
            File::delete(Storage::disk('public')->path(str_replace('/storage', '', $request->imageName)));

            return response()->json(['success' => 'success']);;
        }
    }


}
