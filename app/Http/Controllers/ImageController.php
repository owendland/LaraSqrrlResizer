<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitImageUrl;
use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
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
     * @param \App\Http\Requests\SubmitImageUrl $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubmitImageUrl $request)
    {
        $image             = new Image();
        $image->source_url = $request->get('image_url');

        $image->resized_urls = [
            'thumbnail' => [
                'url' => $request->get('image_url'),
            ],
            'small'     => [
                'url' => $request->get('image_url'),
            ],
        ];

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
                'id'           => $image->id,
                'source_url'   => $image->source_url,
                'resized_urls' => (array)$image->resized_urls,
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
        //
    }
}
