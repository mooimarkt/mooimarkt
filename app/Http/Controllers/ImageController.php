<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    /**
     * Allowed mimetype.
     *
     * @var array
     */
    public $allowed = [
        'image/gif',
        'image/png',
        'image/jpeg',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $images = array();
        foreach ($request->file('files') as $image) {
            // dump($image->getClientMimeType());
            // $path = $image->storeAs('uploads', , 'public');
            try {
                // Check mime
                if (!in_array($image->getClientMimeType(), $this->allowed)) {
                    $errors[] = 'Mime type: ' . $image->getClientMimeType() . ' not allowed';
                    continue;
                }
                // Resize image
                $preview    = Image::make($image)
                    ->resize(740, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }) // resize the image to a width of 740 and constrain aspect ratio (auto height)
                    ->resize(null, 457, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }); // resize the image to a height of 457 and constrain aspect ratio (auto width)
                $filename   = md5(substr(str_replace(' ', '', microtime().microtime()),0,40).time()).'.'.$image->getClientOriginalExtension(); // file "uniqname.ext"
                $folder     = config('image.folder').str_random(2).'/'.str_random(2).'/'; // save to folder
                $path       = public_path($folder); // full path for saving
                if (!file_exists($path)) mkdir($path, 0775, true); // create dir if not exist
                $preview->save($path.$filename); // save resized image

                // create image
                $images[] = \App\AdsImages::create([
                    'adsId' => null,
                    'imagePath' => $folder.$filename
                ]);

            } catch (\Exception $e) {
                 return response()->json([
                    'status'  => 'error',
                    'errors'  => $e->getMessage(),
                ]);
            }
        }
        return response()->json([
            'status'  => !empty($errors) ? 'error' : 'success',
            'errors'  => !empty($errors) ? $errors : 0,
            'images'   => $images,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
