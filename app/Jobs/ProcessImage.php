<?php

namespace App\Jobs;

use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\ImageManager;
use Storage;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Image
     */
    public $image;

    /**
     * @var array
     */
    protected $resize_templates = [
        [
            'name'   => 'square',
            'width'  => 50,
            'height' => 50,
        ],
        [
            'name'   => 'thumbnail',
            'width'  => 100,
            'height' => 67,
        ],
        [
            'name'   => 'small',
            'width'  => 240,
            'height' => 161,
        ],
        [
            'name'   => 'medium',
            'width'  => 500,
            'height' => 334,
        ],
    ];

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
     * @param \Intervention\Image\ImageManager $image_manager
     *
     * @return void
     */
    public function handle(ImageManager $image_manager)
    {
        foreach ($this->resize_templates as $resize_template) {
            $name   = array_get($resize_template, 'name');
            $width  = array_get($resize_template, 'width');
            $height = array_get($resize_template, 'height');

            $resized_image_info = $this->createResizedImage($image_manager, $name, $width, $height);

            $this->setResizedImageInfo($name, $resized_image_info);

            $this->image->save();
        }
    }

    /**
     * @param \Intervention\Image\ImageManager $image_manager
     * @param string                           $name
     * @param int                              $width
     * @param int                              $height
     *
     * @return array
     */
    protected function createResizedImage(ImageManager $image_manager, string $name, int $width, int $height): array
    {
        $resized_image = $image_manager->make($this->image->source_url)->fit($width, $height);

        // Grab the original image encoding and encode the resized image accordingly
        $resized_image->encode($this->getImageFileType());

        return $this->saveResizedImage($name, (string)$resized_image);
    }

    /**
     * @param string $name
     * @param string $resized_image
     *
     * @return array
     */
    protected function saveResizedImage(string $name, string $resized_image): array
    {
        $resized_image_path = "public/{$this->image->id}/{$name}.jpg";

        Storage::put($resized_image_path, $resized_image, 'public');

        $resized_image_url = Storage::url($resized_image_path);

        return [
            'url'  => $resized_image_url,
            'path' => $resized_image_path,
        ];
    }

    /**
     * @param string $name
     * @param array  $image_info
     */
    protected function setResizedImageInfo(string $name, array $image_info): void
    {
        $resized_urls = (array)$this->image->resized_urls;

        array_set($resized_urls, $name, $image_info);

        $this->image->resized_urls = $resized_urls;
    }

    /**
     * @return string
     */
    protected function getImageFileType(): string
    {
        $source_url_pieces = explode('.', $this->image->source_url);
        $encoding          = strtolower(last($source_url_pieces));

        if (strpos($encoding, '?')) {
            $encoding = substr($encoding, 0, strpos($encoding, '?'));
        }

        return $encoding;
    }
}
