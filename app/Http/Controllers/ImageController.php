<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitImageUrl;
use App\Image;
use Illuminate\Http\Request;
use Image as ImageResize;
use Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::paginate(2);

        return view('image.index', ['images' => $images]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SubmitImageUrl $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubmitImageUrl $request)
    {
        $source_url        = $request->get('image_url');
        $image             = new Image();
        $image->source_url = $source_url;

        $image->save();

        $name          = 'thumbnail';
        $resized_image = ImageResize::make($source_url)->resize(50, 50);
        $resized_image->encode('jpg');

        $resized_image_path = "public/{$image->id}/{$name}.jpg";

        \Storage::put($resized_image_path, (string)$resized_image, 'public');

        $resized_image_url = \Storage::url($resized_image_path);

        $resized_urls = (array)$image->resized_urls;
        array_set($resized_urls, "{$name}.url", $resized_image_url);
        array_set($resized_urls, "{$name}.path", $resized_image_path);

        $image->resized_urls = $resized_urls;

        $image->save();

        return redirect()->route('image.show', ['id' => $image->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image $image
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return view(
            'image.show',
            [
                'image' => $image,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image $image
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Image               $image
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image $image
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        foreach ((array)$image->resized_urls as $resized_url) {
            $path = array_get($resized_url, 'path');
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        $image->delete();

        return redirect()->route('image.index')->with('status', 'Image Deleted!');
    }
}
