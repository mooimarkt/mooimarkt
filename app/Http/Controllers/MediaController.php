<?php

namespace App\Http\Controllers;

use App\AdsImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeMedia(Request $request)
    {
        $file = $request->file('file');
        $name = uniqid() . '_' . camel_case($file->getClientOriginalName());
        Storage::putFileAs('/public/uploads/tmp/', $file, $name);

        return response()->json([
            'name'          => Storage::url('uploads/tmp/' . $name),
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $photo = $request->file('file');
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $ext   = strtolower($photo->getClientOriginalExtension());

            if (in_array($ext, $allowedExtensions)) {
                $name = uniqid(Auth::user()->id . '_') . "." . $photo->getClientOriginalExtension();
                Storage::putFileAs('/public/uploads/' . Auth::user()->id, $photo, $name);

                // Resize image
                $preview = Image::make($photo)
                    ->resize(263, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })// resize the image to a width of 340 and constrain aspect ratio (auto height)
                    ->resize(null, 316, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }); // resize the image to a height of 457 and constrain aspect ratio (auto width)
                $folder  = config('image.folder') . Auth::user()->id . '/'; // save to folder
                $path    = public_path($folder); // full path for saving
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                } // create dir if not exist
                $preview->save($path . 'thumb_' . $name);
                $image = Storage::url('uploads/' . Auth::user()->id . '/' . $name);


                return response()->json([
                    'name'          => $image,
                    'original_name' => $photo->getClientOriginalName(),
                ]);
            } else {
                return response(['error', 'The file format is invalid. Supported formats are .jpg, .jpeg, .png.']);
            }
        }
    }

    public function deleteImage(Request $request)
    {
        if ($request->has('imageid')) {
            $adsImage = AdsImages::find($request->imageid);
            $adsImage->delete();

            return response()->json(['name' => $request->filenamenew, 'id' => $adsImage->id]);
        }

        if ($request->filenamenew != null) {
            File::delete(Storage::disk('public')->path(str_replace('/storage', '', $request->filenamenew)));

            $imageName = explode('/', $request->filenamenew);
            array_push($imageName, 'thumb_' . array_pop($imageName));
            $imageThumb = implode('/', $imageName);
            File::delete(Storage::disk('public')->path(str_replace('/storage', '', $imageThumb)));

            return response()->json(['name' => $request->filenamenew]);
        }
    }

}
