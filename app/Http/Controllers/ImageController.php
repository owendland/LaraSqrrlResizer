<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitImageUrl;
use App\Image;
use App\Image\Repositories\ImageRepository;
use Storage;

class ImageController extends Controller
{
    /**
     * @var \App\Image\Repositories\ImageRepository
     */
    protected $repository;

    /**
     * ImageController constructor.
     *
     * @param \App\Image\Repositories\ImageRepository $repository
     */
    public function __construct(ImageRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::paginate(2);

        return view(
            'image.index',
            [
                'images' => $images,
            ]
        );
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
        $this->repository->persist(
            $request->get('image_url'),
            $request->get('name')
        );

        return redirect()->route('image.index')->with('status', 'Image Added!');
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
