<?php

namespace App\Jobs;

use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;

class DeleteImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Image
     */
    protected $image;

    /**
     * Create a new job instance.
     *
     * @param \App\Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Delete all resized images for this image model
        foreach ((array)$this->image->resized_urls as $resized_url) {
            $path = array_get($resized_url, 'path');
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        // Delete the directory for this image id
        if (Storage::exists("public/{$this->image->id}")) {
            Storage::deleteDirectory("public/{$this->image->id}");
        }

        // Delete the image model
        $this->image->delete();
    }
}
