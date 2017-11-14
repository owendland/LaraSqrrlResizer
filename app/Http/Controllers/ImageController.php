<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitImageUrl;
use App\Image;
use App\Jobs\DeleteImage;
use App\Jobs\ProcessImage;
use Faker\Generator;

class ImageController extends Controller
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * ImageController constructor.
     *
     * @param \Faker\Generator $faker
     */
    public function __construct(Generator $faker)
    {
        $this->faker = $faker;

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::paginate(15);

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
        $name = $request->get('name');
        if (is_null($name)) {
            $name = $this->faker->name();
        }

        $image = Image::create(
            [
                'name'       => $name,
                'source_url' => $request->get('image_url'),
            ]
        );

        ProcessImage::dispatch($image);

        return redirect()->route('image.index')->with('status', 'Image Queued For Processing!');
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
        DeleteImage::dispatch($image);

        return redirect()->route('image.index')->with('status', 'Image Queued For Deletion!');
    }
}
