<?php

namespace Tests\Feature;

use App\Image;
use App\Jobs\ProcessImage;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessImageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSimpleProcessImage()
    {
        Storage::fake();

        $source_url = 'https://img.huffingtonpost.com/asset/55a41b64170000680d326a8d.jpeg?ops=scalefit_960_noupscale';

        $image = factory(Image::class)->create(
            [
                'source_url' => $source_url
            ]
        );

        ProcessImage::dispatch($image);

        Storage::disk()->assertExists("public/{$image->id}/thumbnail.jpg");
        Storage::disk()->assertExists("public/{$image->id}/square.jpg");
        Storage::disk()->assertExists("public/{$image->id}/small.jpg");
        Storage::disk()->assertExists("public/{$image->id}/medium.jpg");
    }
}
