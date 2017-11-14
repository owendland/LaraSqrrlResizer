<?php
/**
 * DbImageRepository.php
 *
 * @project horizon-demo
 *
 * @author  owendland
 */

namespace App\Image\Repositories\Implementations;

use App\Image;
use App\Image\Repositories\ImageRepository;
use Faker\Generator;
use Intervention\Image\ImageManager;
use \Illuminate\Filesystem\FilesystemManager;

/**
 * Class DbImageRepository
 *
 * @package App\Image\Repositories\Implementations
 */
class DbImageRepository implements ImageRepository
{
    /**
     * @var \App\Image
     */
    protected $model;

    /**
     * @var \Intervention\Image\ImageManager
     */

    protected $image_manager;

    /**
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    protected $image_storage;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * DbImageRepository constructor.
     *
     * @param \App\Image                               $model
     * @param \Intervention\Image\ImageManager         $image_manager
     * @param \Illuminate\Filesystem\FilesystemManager $image_storage
     * @param \Faker\Generator                         $faker
     */
    public function __construct(
        Image $model,
        ImageManager $image_manager,
        FilesystemManager $image_storage,
        Generator $faker
    ) {
        $this->model         = $model;
        $this->image_manager = $image_manager;
        $this->image_storage = $image_storage;
        $this->faker         = $faker;
    }

    /**
     * @param string      $source_url
     * @param string|null $name
     *
     * @return \App\Image
     */
    public function persist(string $source_url, string $name = null): Image
    {
        if (is_null($name)) {
            $name = $this->faker->name();
        }

        $image = $this->model->create(
            [
                'name'       => $name,
                'source_url' => $source_url,
            ]
        );

        $name          = 'thumbnail';
        $resized_image = $this->image_manager->make($source_url)->resize(50, 50);
        $resized_image->encode('jpg');

        $resized_image_path = "public/{$image->id}/{$name}.jpg";

        $this->image_storage->put($resized_image_path, (string)$resized_image, 'public');

        $resized_image_url = $this->image_storage->url($resized_image_path);

        $resized_urls = (array)$image->resized_urls;
        array_set($resized_urls, "{$name}.url", $resized_image_url);
        array_set($resized_urls, "{$name}.path", $resized_image_path);

        $image->resized_urls = $resized_urls;

        $image->save();

        return $image;
    }
}